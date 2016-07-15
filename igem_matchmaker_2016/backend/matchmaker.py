#!/usr/bin/env python
import sys, getopt
import re
import os
import pickle
import time, datetime
import math
import json
from json import encoder
encoder.FLOAT_REPR = lambda o: format(o, '.2f')
from operator import itemgetter, attrgetter
reload(sys)
sys.setdefaultencoding('utf8')

# Print script usage information and exit
def help():
    print 'matchmaker.py -t <teamInfoFile> -i <inputFile> -o <outputFile>'
    sys.exit(2)
    
# Remove pairs with incorrect encoding
def cleanTeamsKeywords(teamsKeywords):
    result=[]
    for team in teamsKeywords:
        keywords=team["keywords"]
        if len(keywords)>0:
            pairs=[]
            for pair in keywords:
                try:
                    x=json.dumps(pair)
                    pairs.append(pair)
                except UnicodeDecodeError:
                    x=pair
            team.update({"keywords":pairs})
            result.append(team)
    return result
    
# Asymmetric calculation of matchmaker score
def matchmakerScore(pairs1,pairs2):
    total=0
    score=0
    for pair1 in pairs1:
        total+=pair1["weight"]**2
        matchingPair=[pair2 for pair2 in pairs2 if pair2["text"]==pair1["text"]]
        if len(matchingPair)>0:
            pair2=matchingPair[0]
            product=pair1["weight"]*pair2["weight"]
            if product>=pair1["weight"]**2:
                score+=pair1["weight"]**2
            else:
                score+=product
    return math.sqrt(score/total)
    
# Calculation of matchmaker score in a symmetric way
def matchmakerScoreSymmetric(pairs1,pairs2):
    total=0
    score=0
    for pair1 in pairs1:
        matchingPair=[pair2 for pair2 in pairs2 if pair2["text"]==pair1["text"]]
        if len(matchingPair)==0:
            total+=pair1["weight"]**2
        else:
            pair2=matchingPair[0]
            total+=max(pair1["weight"],pair2["weight"])**2
            score+=pair1["weight"]*pair2["weight"]
    for pair2 in pairs2:
        matchingPair=[pair1 for pair1 in pairs1 if pair1["text"]==pair2["text"]]
        if len(matchingPair)==0:
            total+=pair2["weight"]**2
    return math.sqrt(score/total)
    # l1=len(pairs1)
    # l2=len(pairs2)
    # total=0
    # score=0
    # for i1 in range(0,l1):
    #     for  i2 in range(0,l2):
    #         if pairs1[i1]["text"]==pairs2[i2]["text"]:
    #             score+=pairs1[i1]["weight"]*pairs2[i2]["weight"]
    # return score
    
# Calculate all possible matchscores between the teams
def calculateAllMatchscores(teamsKeywords):
    l=len(teamsKeywords)
    matchscores=[]
    for i1 in range(0,l):
        row=[]
        for i2 in range(0,l):
            score=matchmakerScore(teamsKeywords[i1]["keywords"],teamsKeywords[i2]["keywords"])
            row.append(score)
        matchscores.append(row)
    return matchscores
    
# Return a dictionary with team information and matchmaking information
# which includes most helpful and teams most in need of help
def matchmaker(teamsKeywords,teamsInfo):
    matchscores=calculateAllMatchscores(teamsKeywords)
    teamsMatchmaking=[]
    i1=0
    for teamMatchmaking in teamsKeywords:
        l2=len(matchscores[i1])
        pairsMostHelpful=[]
        pairsMostInNeed=[]
        for i2 in range(0,l2):
            pairsMostHelpful.append((teamsKeywords[i2]["name"],matchscores[i1][i2]))
            pairsMostInNeed.append((teamsKeywords[i2]["name"],matchscores[i2][i1]))
        pairsMostHelpful=sorted(pairsMostHelpful, key=itemgetter(1), reverse=True)
        pairsMostInNeed=sorted(pairsMostInNeed, key=itemgetter(1), reverse=True)
        
        matchesMostHelpful=[]
        for pair in pairsMostHelpful:
            if pair[1]>0:
                matchesMostHelpful.append({"name":pair[0],"score":pair[1]})
        teamMatchmaking.update({"matchesMostHelpful":matchesMostHelpful[1:11]})
        
        matchesMostInNeed=[]
        for pair in pairsMostInNeed:
            if pair[1]>0:
                matchesMostInNeed.append({"name":pair[0],"score":pair[1]})
        teamMatchmaking.update({"matchesMostInNeed":matchesMostInNeed[1:11]})
        
        # Add team Info
        teamMatches=[teamInfo for teamInfo in teamsInfo if teamInfo["id"] == teamMatchmaking["id"]]
        teamInfo=teamMatches[0]
        name=teamInfo["name"]
        description=teamInfo["description"]
        title=teamInfo["title"]
        abstract=teamInfo["abstract"]
        teamMatchmaking.update({"name":name})
        teamMatchmaking.update({"title":title})
        teamMatchmaking.update({"abstract":abstract})
        
        # Add to list
        teamsMatchmaking.append(teamMatchmaking)
        i1=i1+1
    return teamsMatchmaking
	
# Main program
def main(argv): 
   teamInfoFile=''
   inputFile = ''
   outputFile = ''
   try:
      opts, args = getopt.getopt(argv,"ht:i:o:")
   except getopt.GetoptError:
      help()
   if len(opts) == 0:
      help()
   for opt, arg in opts:
      if opt == '-h':
         help()
      elif opt in ("-t"):
         teamInfoFile = arg
      elif opt in ("-i"):
         inputFile = arg
      elif opt in ("-o"):
         outputFile = arg    
   # For debugging purposes
   print 'Team info file is', teamInfoFile
   print 'Input file is', inputFile
   print 'Output file is', outputFile
   # Load team info file
   filename=teamInfoFile
   f=open(filename,'r')
   teamsInfo=pickle.load(f)
   f.close()
   # Load and clean keywords
   filename=inputFile
   f=open(filename,'r')
   teamsKeywords=pickle.load(f)
   f.close()
   teamsKeywords=cleanTeamsKeywords(teamsKeywords)
   # Matchmaker
   teamsMatchmaking=matchmaker(teamsKeywords,teamsInfo)
   # Writing Matchmaker results in JSON file
   f = open(outputFile,'w')
   f.write(json.dumps(json.loads(json.dumps(teamsMatchmaking), parse_float=lambda x: round(float(x), 4))))
   f.close()
   

if __name__ == "__main__":
   main(sys.argv[1:])