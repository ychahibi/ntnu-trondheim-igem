#!/usr/bin/env python
# encoding=utf8
import sys
sys.setrecursionlimit(4000000)
import re
import os
import shlex, subprocess
import pickle
import html2text
import time, datetime
import math
import json
from json import encoder
encoder.FLOAT_REPR = lambda o: format(o, '.2f')
from operator import itemgetter, attrgetter
reload(sys)
sys.setdefaultencoding('utf8')

import urllib2
from bs4 import BeautifulSoup

# teams=getteamsInfo()
# teamsInfo=[{'teamUrl': u'http://igem.org/Team.cgi?id=1768', 'id': u'1768', 'name': u'Pretoria_UP'}, {'url': u'http://igem.org/Team.cgi?id=1751', 'id': u'1751', 'name': u'AHUT_China'}, {'url': u'http://igem.org/Team.cgi?id=1719', 'id': u'1719', 'name': u'Amoy'}, {'url': u'http://igem.org/Team.cgi?id=1750', 'id': u'1750', 'name': u'ANU-Canberra'}]   

def getTeamsInfo():
    url="http://igem.org/Team_List?year=2015"
    html_doc=urllib2.urlopen(url)
    soup = BeautifulSoup(html_doc, 'html.parser')
    hits=soup.find_all(style="border: none;")
    result=[]
    for hit in hits:
        if hit.a!=None:
            if hit.a.get('style').find("color:blue")>=0:
                teamName=hit.a.string
                teamUrl=hit.a.get('href')
                teamId=re.search("\d+$",teamUrl).group()
                teamInfo={'name':teamName,'url':teamUrl,'id':teamId}
                teamPage=getTeamPage(teamId)
                if teamPage["abstract"]!=u'-- No abstract provided yet --\n' and teamPage["abstract"]!=u"":
                    teamInfo.update(teamPage)
                    teamDescription=getTeamDescription(teamName)
                    teamInfo.update({"description":teamDescription})
                    result.append(teamInfo)
    return result
    
def getIdByName(teamsInfo,teamName):
    return [k for k in range(len(teamsInfo)) if teamsInfo[k]["name"]==teamName][0]
    
def getTeamId(teamsInfo,teamName):
    return [team["id"] for team in teamsInfo if team["name"] == teamName][0]
    
def getTeamPage(teamId):
    url="http://igem.org/Team.cgi?id=%s" % teamId
    tempFile="abstract_%s.html" % teamId
    command_line="wget %s -O %s" % (url, tempFile)
    devnull = open('/dev/null', 'w')
    process = subprocess.Popen(shlex.split(command_line), stdout=devnull, stderr=devnull)
    retcode = process.wait()
    f = open(tempFile, 'r')
    html_doc=f.read()
    command_line="rm %s" % tempFile
    process = subprocess.Popen(shlex.split(command_line), stdout=devnull, stderr=devnull)
    retcode = process.wait()
    soup = BeautifulSoup(html_doc, 'html.parser')
    title_and_abstract=soup.find(id="table_abstract").tr.td.get_text()
    separatorIndex=title_and_abstract.find("\n")
    title=title_and_abstract[0:separatorIndex]
    abstract=title_and_abstract[separatorIndex+1:]
    result={"title":title,"abstract":abstract}
    return result

def getTeamDescription(teamName):
    url="http://2015.igem.org/Team:%s/Description" % teamName
    html=urllib2.urlopen(url).read()
    h=html2text.HTML2Text()
    h.ignore_links=True
    h.ignore_images=True
    text=h.handle(html)
    if text.find("What should this page contain?")>=0:
        return ""
    else:
        return text
    
def writeTeamsInfo(teamsInfo):
    t_now = time.time()
    timeStamp = datetime.datetime.fromtimestamp(t_now).strftime('%Y%m%d%H%M%S')
    f = open('teamsInfo_%s.pkl' % timeStamp,'w')
    pickle.dump(teamsInfo,f)
    f.close()
    f = open('teamsInfo_%s.txt' % timeStamp,'w')
    f.write(str(teamsInfo))
    f.close()
    # teamPage["abstract"]!=u'-- No abstract provided yet --\n'
    # teamsInfoCleared=[teamInfo for teamInfo in teamsInfo if teamInfo["abstract"] != u'-- No abstract provided yet --\n']
    # f = open('teamsInfoCleared.txt','w')
    # f.write(str(teamsInfoCleared))
    # f.close()
    return teamsInfo
    
def extractKeywords(filename,nKeywords):
    command="java -Xmx1024m -jar MAUI/maui-standalone-1.1-SNAPSHOT.jar run %s -m MAUI/data/models/keyword_extraction_model -v none -n %s" % (filename, nKeywords)
    maui_out=os.popen(command).read()
    maui_out=maui_out.split('\n')
    keywords=[]
    weights=[]
    pairs=[]
    for line in maui_out:
        if line:
            line=line.replace("Keyword: ", "")
            delimiter=line.rfind(' ')
            keyword=line[:delimiter]
            weight=num(line[delimiter+1:])
            keywords.append(keyword)
            weights.append(weight)
            pairs.append({"keyword":keyword,"weight":weight})
    return pairs

def num(s):
    try:
        return int(s)
    except ValueError:
        return float(s)
        
def teamsKeywords(filename):
    teamsKeywords=[]
    filename="teamsInfo_20150911185640.pkl"
    f=open(filename,'r')
    teamsInfo=pickle.load(f)
    f.close()
    nKeywords=30
    for teamInfo in teamsInfo:
        id=teamInfo["id"]
        name=teamInfo["name"]
        description=teamInfo["description"]
        title=teamInfo["title"]
        abstract=teamInfo["abstract"]
    
        # Entry
        entry={}
        entry.update({"id":id})
        entry.update({"name":name})
    
        # Create temporary text file with description
        filename="description_%s.txt" % id
        f=open(filename,'w')
        f.write(abstract)
        f.write(description)
        f.close()

        # Keywords extraction
        keywords=extractKeywords(filename,nKeywords)
        entry.update({"keywords":keywords})
        teamsKeywords.append(entry)
    
        # Delete description file
        devnull = open('/dev/null', 'w')
        command_line="rm %s" % filename
        process = subprocess.Popen(shlex.split(command_line), stdout=devnull, stderr=devnull)
        retcode = process.wait()
    
    # Write 
    t_now = time.time()
    timeStamp = datetime.datetime.fromtimestamp(t_now).strftime('%Y%m%d%H%M%S')
    f = open('teamsKeywords_%s.pkl' % timeStamp,'w')
    pickle.dump(teamsKeywords,f)
    f.close()
    return teamsKeywords

def matchmakerScore(pairs1,pairs2):
    total=0
    score=0
    for pair1 in pairs1:
        total+=pair1["weight"]**2
        matchingPair=[pair2 for pair2 in pairs2 if pair2["keyword"]==pair1["keyword"]]
        if len(matchingPair)>0:
            pair2=matchingPair[0]
            product=pair1["weight"]*pair2["weight"]
            if product>=pair1["weight"]**2:
                score+=pair1["weight"]**2
            else:
                score+=product
    return math.sqrt(score/total)
    
def matchmakerScoreSymmetric(pairs1,pairs2):
    total=0
    score=0
    for pair1 in pairs1:
        matchingPair=[pair2 for pair2 in pairs2 if pair2["keyword"]==pair1["keyword"]]
        if len(matchingPair)==0:
            total+=pair1["weight"]**2
        else:
            pair2=matchingPair[0]
            total+=max(pair1["weight"],pair2["weight"])**2
            score+=pair1["weight"]*pair2["weight"]
    for pair2 in pairs2:
        matchingPair=[pair1 for pair1 in pairs1 if pair1["keyword"]==pair2["keyword"]]
        if len(matchingPair)==0:
            total+=pair2["weight"]**2
    return math.sqrt(score/total)
    # l1=len(pairs1)
    # l2=len(pairs2)
    # total=0
    # score=0
    # for i1 in range(0,l1):
    #     for  i2 in range(0,l2):
    #         if pairs1[i1]["keyword"]==pairs2[i2]["keyword"]:
    #             score+=pairs1[i1]["weight"]*pairs2[i2]["weight"]
    # return score
    
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
            matchesMostHelpful.append({"name":pair[0],"score":pai[1]})
        teamMatchmaking.update({"matchesMostHelpful":matchesMostHelpful[1:11]})
        
        matchesMostInNeed=[]
        for pair in pairsMostInNeed:
            matchesMostInNeed.append({"name":pair[0],"score":pair[1]})
        teamMatchmaking.update({"matchesMostInNeed":matchesMostInNeed[1:11]})
        
        # Add team Info
        teamInfo=teamsInfo[i1]
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
        
def cleanTeamsKeywords(teamsKeywords):
    result=[]
    for team in teamsKeywords:
        keywords=team["keywords"]
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
            
    
# teamsInfo=getTeamsInfo();
filename="teamsInfo_20150911150008.pkl"
f=open(filename,'r')
teamsInfo=pickle.load(f)
f.close()        
        
# teamsKeywords=teamsKeywords(filename)
filename="teamsKeywords_20150911191436.pkl"
f=open(filename,'r')
teamsKeywords=pickle.load(f)
f.close()
teamsKeywords=cleanTeamsKeywords(teamsKeywords)

teamsMatchmaking=matchmaker(teamsKeywords,teamsInfo)
t_now = time.time()
timeStamp = datetime.datetime.fromtimestamp(t_now).strftime('%Y%m%d%H%M%S')
f = open('teamsMatchmaking_%s.pkl' % t_now,'w')
pickle.dump(teamsMatchmaking,f)
f.close()
f = open('teamsMatchmaking_%s.txt' % timeStamp,'w')
f.write(str(teamsMatchmaking))
f.close()
filename='teamsMatchmaking_%s.json' % t_now
f = open(filename,'w')
f.write(json.dumps(json.loads(json.dumps(teamsMatchmaking), parse_float=lambda x: round(float(x), 4))))
f.close()

# k for k in range(1,len(teamsKeywords[10]["keywords"])) if teamsKeywords[10]["keywords"][k]["keyword"]=="\x80\x94"]
# teamsKeywords[10]["keywords"].pop(5)