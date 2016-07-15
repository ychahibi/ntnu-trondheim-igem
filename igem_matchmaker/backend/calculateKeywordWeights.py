#!/usr/bin/env python
# -*- coding: utf-8 -*- 
import sys, getopt
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


        
# Print script usage information and exit
def help():
    print 'calculateKeywordWeights.py -i <inputFile> -o <outputFile> [-m <MAUI JAR>] [-e <MAUI extraction model>]'
    sys.exit(2)
    
# Transform a string into a number
def num(s):
    try:
        return int(s)
    except ValueError:
        return float(s)
    
# Check if the keyword line returned by MAUI is valid
def isLineInMAUIValid(line):
    if line=="":
        return False
    if not ("Keyword: " in line):
        return False
    blacklist=["practices","using","team","project","description","using","concept","than","use","home","team","safety","history","introduction","results","parts","experiments","proof","demonstrate","results","notebook","basic","collection","attribution","silver","gold","integrated","engagement","entrepreneurship","hardware","software","measurement","model","upload","name in","style","loading","requirements","lab","iGEM","wiki","pictures and files","edit this page", "information should be","awards here ","template", "http","start","awards","human","margin","weight","file"]
    if any(blacklisted.upper() in line.upper() for blacklisted in blacklist):
        return False
    return True
    
# Take a filename and return nKeywords keywords with their respective
# weights. The MAUI is assumed to be in MAUI/maui-standalone-1.1-SNAPSHOT.jar
def extractKeywords(mauiJar,mauiExtractionModel,filename,nKeywords):
    command="java -Xmx1024m -jar %s run %s -m %s -v none -n %s" % (mauiJar,filename, mauiExtractionModel, nKeywords)
    maui_out=os.popen(command).read()
    maui_out=maui_out.split('\n')
    keywords=[]
    weights=[]
    pairs=[]
    for line in maui_out:
        if isLineInMAUIValid(line):
            print line
            line=line.replace("Keyword: ", "")
            delimiter=line.rfind(' ')
            keyword=line[:delimiter]
            weight=num(line[delimiter+1:])
            keywords.append(keyword)
            weights.append(weight)
            pairs.append({"text":keyword,"weight":weight})
    return pairs
    
# Write a dump of team keywords and info
def teamsKeywords(mauiJar,mauiExtractionModel,inputFile,outputFile):
    teamsKeywords=[]
    filename=inputFile
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
        keywords=extractKeywords(mauiJar,mauiExtractionModel,filename,nKeywords)
        entry.update({"keywords":keywords})
        teamsKeywords.append(entry)
    
        # Delete description file
        devnull = open('/dev/null', 'w')
        command_line="rm %s" % filename
        process = subprocess.Popen(shlex.split(command_line), stdout=devnull, stderr=devnull)
        retcode = process.wait()
    
    # Write 
    # t_now = time.time()
    # timeStamp = datetime.datetime.fromtimestamp(t_now).strftime('%Y%m%d%H%M%S')
    # f = open('teamsKeywords_%s.pkl' % timeStamp,'w')
    f = open(outputFile,'w')
    pickle.dump(teamsKeywords,f)
    f.close()
    return teamsKeywords

# Main program
def main(argv): 
   inputFile = ''
   outputFile = ''
   mauiJar= 'MAUI/maui-standalone-1.1-SNAPSHOT.jar'
   mauiExtractionModel= 'MAUI/data/models/keyword_extraction_model'
   try:
      opts, args = getopt.getopt(argv,"hi:o:m:e:")
   except getopt.GetoptError:
      help()
   if len(opts) == 0:
      help()
   for opt, arg in opts:
      if opt == '-h':
         help()
      elif opt in ("-i"):
         inputFile = arg
      elif opt in ("-o"):
         outputFile = arg
      elif opt in ("-m"):
         mauiJar = arg
      elif opt in ("-e"):
         mauiExtractionModel = arg         
   # For debugging purposes
   print 'Input file is', inputFile
   print 'Output file is', outputFile
   print 'MAUI Jar is', mauiJar
   print 'MAUI extraction model is', mauiExtractionModel
   # Calculate and write teams keywords
   result=teamsKeywords(mauiJar,mauiExtractionModel,inputFile,outputFile)

  

if __name__ == "__main__":
   main(sys.argv[1:])