#!/usr/bin/env python
# -*- coding: utf-8 -*- 
import sys, getopt
import re
import os
import csv
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
    print 'downloadAllTeamsInfos.py -y <year> -o <outputFile>'
    sys.exit(2)
    
#Clean description
def cleanDescription(description):
    strings=["""MENU ▤

  * HOME 
  * TEAM 
    * Team 
    * ★ Collaborations 
  * PROJECT 
    * ★ Description 
    * ★ Design 
    * Experiments 
    * ★ Proof of Concept 
    * ★ Demonstrate 
    * Results 
    * Notebook 
  * PARTS 
    * Parts 
    * ★ Basic Parts 
    * ★ Composite Parts 
    * ★ Part Collection 
  * SAFETY 
  * ★ ATTRIBUTIONS 
  * HUMAN PRACTICES 
    * Human Practices 
    * ★ Silver 
    * ★ Gold 
    * ★ Integrated Practices 
    * ★ Engagement 
  * AWARDS 
    * ★ Entrepreneurship 
    * ★ Hardware 
    * ★ Software 
    * ★ Measurement 
    * ★ Model 

""","""##  Welcome to iGEM 2016!

Your team has been approved and you are ready to start the iGEM season!

##### Before you start:

Please read the following pages:

  * Requirements page 
  * Wiki Requirements page
  * Template Documentation 

#####  Styling your wiki

You may style this page as you like or you can simply leave the style as it
is. You can easily keep the styling and edit the content of these default wiki
pages with your project information and completely fulfill the requirement to
document your project.

While you may not win Best Wiki with this styling, your team is still eligible
for all other awards. This default wiki meets the requirements, it improves
navigability and ease of use for visitors, and you should not feel it is
necessary to style beyond what has been provided.

#####  Wiki template information

We have created these wiki template pages to help you get started and to help
you think about how your team will be evaluated. You can find a list of all
the pages tied to awards here at the Pages for awards link. You must edit
these pages to be evaluated for medals and awards, but ultimately the design,
layout, style and all other elements of your team wiki is up to you!

#####  Editing your wiki

On this page you can document your project, introduce your team members,
document your progress and share your iGEM experience with the rest of the
world!

Use WikiTools - Edit in the black menu bar to edit this page

##### Tips

This wiki will be your team’s first interaction with the rest of the world, so
here are a few tips to help you get started:

  * State your accomplishments! Tell people what you have achieved from the start. 
  * Be clear about what you are doing and how you plan to do this.
  * You have a global audience! Consider the different backgrounds that your users come from.
  * Make sure information is easy to find; nothing should be more than 3 clicks away. 
  * Avoid using very small fonts and low contrast colors; information should be easy to read. 
  * Start documenting your project as early as possible; don’t leave anything to the last minute before the Wiki Freeze. For a complete list of deadlines visit the iGEM 2016 calendar
  * Have lots of fun! 

##### Inspiration

You can also view other team wikis for inspiration! Here are some examples:

  * 2014 SDU Denmark 
  * 2014 Aalto-Helsinki
  * 2014 LMU-Munich
  * 2014 Michigan
  * 2014 ITESM-Guadalajara 
  * 2014 SCU-China 

#####  Uploading pictures and files

You can upload your pictures and files to the iGEM 2016 server. Remember to
keep all your pictures and files within your team's namespace or at least
include your team's name in the file name.  
When you upload, set the "Destination Filename" to  
`T--YourOfficialTeamName--NameOfFile.jpg`. (If you don't do this, someone else
might upload a different file with the same "Destination Filename", and your
file would be erased!)

UPLOAD FILES
""","""###  Loading ...""","""### ★ ALERT!
""","""
This page is used by the judges to evaluate your team for the improve a
previous part or project gold medal criterion.""","""
Delete this box in order to be evaluated for this medal. See more information
at  Instructions for Pages for awards.

Tell us about your project, describe what moves you and why this is something
important for your team.""","""
##### What should this page contain?

  * A clear and concise description of your project.
  * A detailed explanation of why your team chose to work on this particular project.
  * References and sources to document your research.
  * Use illustrations and other visual resources to explain your project.

##### Advice on writing your Project Description""","""
We encourage you to put up a lot of information and content on your wiki, but
we also encourage you to include summaries as much as possible. If you think
of the sections in your project description as the sections in a publication,
you should try to be consist, accurate and unambiguous in your achievements.

Judges like to read your wiki and know exactly what you have achieved. This is
how you should think about these sections; from the point of view of the judge
evaluating you at the end of the year.
""","""##### References

iGEM teams are encouraged to record references you use during the course of
your research. They should be posted somewhere on your wiki so that judges and
other visitors can see how you thought about your project and what works
inspired you.

##### Inspiration

See how other teams have described and presented their projects:

  * Imperial
  * UC Davis
  * SYSU Software
""","""Loading menubar.....""","""
#

####






×



""","""Toggle navigation

  * Project 
    * Description
    * Design
    * Experiment
    * Proof Of Concept
    * Demonstration
    * Results
    * Notebook
    * Gallery
  * Team 
    * Team Members
    * Advisors
    * Collaborations
  * Parts 
    * Parts
    * Basic Parts
    * Composite Parts
    * Part Collection
  * Awards 
    * Entrepreneurship
    * Hardware
    * Software
    * Measurement
    * Model
  * Medals 
    * Bronze
    * Silver
    * Gold
  * Human Practices 
    * Human Practices
    * Silver
    * Gold
    * Integrated Practices
    * Engagement
  * Safety
  * Attributions""","""  * Team 
    * Us
    * Collaborations
  * Project 
    * Overview
    * Results
    * Project Build
    * Application
    * Documentation
    *     * Attributions
  * Notebook 
    * Timeline
    * Experiments
    * Safety
  * Human Practices 
    * Overview
    * Silver
    * Gold
    * Integrated Practices
    * Engagement
  * Awards 
    * Hardware
    * Software
    * Entrepreneurship
    * Measurement
    * Model
""","""##### Before you start:

Please read the following pages:

  * Requirements page 
  * Wiki Requirements page
  * Template Documentation 

#####  Styling your wiki

You may style this page as you like or you can simply leave the style as it
is. You can easily keep the styling and edit the content of these default wiki
pages with your project information and completely fulfill the requirement to
document your project.

While you may not win Best Wiki with this styling, your team is still eligible
for all other awards. This default wiki meets the requirements, it improves
navigability and ease of use for visitors, and you should not feel it is
necessary to style beyond what has been provided.

#####  Wiki template information

We have created these wiki template pages to help you get started and to help
you think about how your team will be evaluated. You can find a list of all
the pages tied to awards here at the Pages for awards link. You must edit
these pages to be evaluated for medals and awards, but ultimately the design,
layout, style and all other elements of your team wiki is up to you!

#####  Editing your wiki

On this page you can document your project, introduce your team members,
document your progress and share your iGEM experience with the rest of the
world!

Use WikiTools - Edit in the black menu bar to edit this page

##### Tips

This wiki will be your team’s first interaction with the rest of the world, so
here are a few tips to help you get started:

  * State your accomplishments! Tell people what you have achieved from the start. 
  * Be clear about what you are doing and how you plan to do this.
  * You have a global audience! Consider the different backgrounds that your users come from.
  * Make sure information is easy to find; nothing should be more than 3 clicks away. 
  * Avoid using very small fonts and low contrast colors; information should be easy to read. 
  * Start documenting your project as early as possible; don’t leave anything to the last minute before the Wiki Freeze. For a complete list of deadlines visit the iGEM 2016 calendar
  * Have lots of fun! 

##### Inspiration

You can also view other team wikis for inspiration! Here are some examples:

  * 2014 SDU Denmark 
  * 2014 Aalto-Helsinki
  * 2014 LMU-Munich
  * 2014 Michigan
  * 2014 ITESM-Guadalajara 
  * 2014 SCU-China 

#####  Uploading pictures and files

You can upload your pictures and files to the iGEM 2016 server. Remember to
keep all your pictures and files within your team's namespace or at least
include your team's name in the file name.  
When you upload, set the "Destination Filename" to  
`T--YourOfficialTeamName--NameOfFile.jpg`. (If you don't do this, someone else
might upload a different file with the same "Destination Filename", and your
file would be erased!)""","""UPLOAD FILES""","""

×


""","""UPLOAD FILES"""]
    for string in strings:
        description=description.replace(string,"")
    return description
    
    
# Return the team information for a year in a dictionary format
# This function fetches the abstract and the description page
# of the team
def getTeamsInfo(year):
    url="http://igem.org/Team_List.cgi?year=%s&division=igem&team_list_download=1" % year
    tempFile="team_list_%s.csv" % year
    command_line="wget %s -O %s" % (url, tempFile)
    devnull = open('/dev/null', 'w')
    process = subprocess.Popen(shlex.split(command_line), stdout=devnull, stderr=devnull)
    retcode = process.wait()
    csvfile=open(tempFile)
    reader = csv.DictReader(csvfile)
    result=[]
    for row in reader:
        teamName=row[' Team  ']
        teamId=row['Team ID ']
        teamUrl='http://igem.org/Team.cgi?team_id=%s' % teamId
        teamInfo={'name':teamName,'url':teamUrl,'id':teamId}
        teamPage=getTeamPage(teamId)
        # if teamPage["abstract"]==u'-- No abstract provided yet --\n':
        #     teamPage["abstract"]=''
        if teamPage["title"]==u'-- Not provided yet --':
            teamPage["title"]=''
        teamInfo.update(teamPage)
        teamDescription=getTeamDescription(year,teamName)
        teamDescription=cleanDescription(teamDescription)
        teamInfo.update({"description":teamDescription})
        if not (len(teamDescription)<50 and teamPage["abstract"]==u'-- No abstract provided yet --\n'):
            print teamPage
            print teamDescription
            result.append(teamInfo)
    teamsInfo=result
    return teamsInfo    
    
# Get title and abstract of a team from the iGEM page
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

# Get team description from team website
def getTeamDescription (year,teamName):
    urlMain="http://%s.igem.org/Team:%s" % (year, teamName)
    urlDescription="http://%s.igem.org/Team:%s/Description" % (year, teamName)
    result=""
    for url in [urlMain,urlDescription]:
        try: 
            html=urllib2.urlopen(url).read()
            h=html2text.HTML2Text()
            h.ignore_links=True
            h.ignore_images=True
            text=h.handle(html)
            if text.find("What should this page contain?")>=0:
                result+=""
            else:
                result+=text
        except urllib2.HTTPError:
            result+=""
    return result
#    urlDescription="http://%s.igem.org/Team:%s/Description" % (year, teamName)
#    urlMain="http://%s.igem.org/Team:%s" % (year, teamName)
#    finalText=""
#    for url in [urlDescription, urlMain]:
#        try: 
#            html=urllib2.urlopen(url).read()
#            h=html2text.HTML2Text()
#            h.ignore_links=True
#            h.ignore_images=True
#            text=h.handle(html)
#            if text.find("What should this page contain?")>=0:
#                text=""
#        except urllib2.HTTPError:
#            text=""
#        finalText=finalText+text
#    return finalText

# Write a dump of the teams info in a Pickle file
def writeTeamsInfo(teamsInfo,outputFile):
    t_now = time.time()
    timeStamp = datetime.datetime.fromtimestamp(t_now).strftime('%Y%m%d%H%M%S')
    f = open(outputFile,'w')
    pickle.dump(teamsInfo,f)
    f.close()
    # teamPage["abstract"]!=u'-- No abstract provided yet --\n'
    # teamsInfoCleared=[teamInfo for teamInfo in teamsInfo if teamInfo["abstract"] != u'-- No abstract provided yet --\n']
    # f = open('teamsInfoCleared.txt','w')
    # f.write(str(teamsInfoCleared))
    # f.close()
    return teamsInfo
    
# Main program
def main(argv): 
   year = ''
   outputfile = ''
   try:
      opts, args = getopt.getopt(argv,"hy:o:")
   except getopt.GetoptError:
      help()
   if len(opts) == 0:
      help()
   for opt, arg in opts:
      if opt == '-h':
         help()
      elif opt in ("-y"):
         year = arg
      elif opt in ("-o"):
         outputfile = arg
   # For debugging purposes
   print 'Year is', year
   print 'Output file is', outputfile
   teamsInfo=getTeamsInfo(year)
   writeTeamsInfo(teamsInfo,outputfile)
   return 1
 
if __name__ == "__main__":
   main(sys.argv[1:])