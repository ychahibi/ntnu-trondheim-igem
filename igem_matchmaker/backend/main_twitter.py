#!/usr/bin/env python
# encoding=utf8
import sys
import re
import pickle
import json
from json import encoder
reload(sys)
sys.setdefaultencoding('utf8')


filename="teamsInfo_20150911150008.pkl"
f=open(filename,'r')
teamsInfo=pickle.load(f)
f.close()        

names=[team["name"] for team in teamsInfo]
twitters=["iGEM_spacep", "igem_iitkgp", "Igem_Groningen", "UNSW_iGEM", "Sydney_iGEM", "EPFL_iGEM", "iGEMCambridge", "wmigem", "UMassD_iGEM", "iGEM_TecChih", "anu_igem", "WarwickIGEM15", "igem_kent", "Columbia_iGEM", "NEU_iGEM", "DanciGEM2015", "HarvardiGEM2015", "igemlzu", "WestminsteriGEM", "iGEMBU", "igem_HUSTChina", "iGEMCGU_Taiwan", "iGEM_ETHZ_2015", "2015iGEMglasgow", "iGEM_Evry_2015", "iGEM_Nokogen", "WPI_iGEM", "TCDiGem", "iGEM_BIT", "iGEMSDU2015", "PittiGEM2015", "iGEM_McMaster", "Vilnius_iGEM", "Amoy_igem", "Rock_Ridge_IGEM", "igemdam2015", "MQ_AUST_iGEM", "iGEM_DTU", "iGEMTrento", "iGEMsthlm", "iGEM_Peking", "Atlantis_iGEMHS", "UMDiGEM", "USCiGEM", "igemsjtu", "baskentigem", "iGEM_SYSU_China", "igemsaarland", "CIDEBIGEM", "NYCiGEM", "Vanderbilt_iGEM", "lamberths_iGEM", "Eindhoven_iGEM", "Cork_iGEM", "iGEM_Darmstadt", "UW_iGEM_Team", "Tianjin_iGEM", "iGEM_Marburg", "hSiGEM", "iGEMMancGraz", "iGemMilano", "iGEM_Pasteur", "IONIS_iGEM", "GSUiGEM", "EdiGEM2015", "toulouse_igem", "iGEMUNAH", "ExeteriGEM2015", "mstigem", "tsukuba_igem", "iGEM_METU15", "UoBiGEM", "iGEM_UPO", "iGEM_FDR", "iGEMZAMORANO", "CityUHK_iGEM", "vinoo_iGEM", "UGA_iGEM_Team", "MOOC_iGEMhs", "BGU_iGEM", "Buff_iGEM", "MontyiGEM", "Virginia_iGEM", "ETH_iGEM", "iGEMGoe", "Colombia_igem1", "CaltechIGEM", "CMUiGEM", "iGEM_TAS", "iGEMW", "iGEMSheffield", "iGEMHeidelberg", "RUiGEMTeam", "CentraliGEM", "iGEMTUDelftLeid", "CSU_iGEM", "OxfordiGEM", "BBKiGEM", "hzau_igem", "UPVigem", "Kelly_iGEM", "iGEMUB", "Yale_iGEM", "iGEM_CIDEB", "iGEMBaskent", "OLeSsence_iGEM", "iGEMChattanooga", "UiOslo_iGEM", "SPS_iGEM", "bilgiigem", "METUHSiGEM", "iGEM_Nagahama", "iGEMSBU", "iGEMyork", "iGEMgifu", "iGEM_Toulouse", "UT_iGEM", "iGEMUFMG", "BerkeleyiGEM", "Pitt_iGem", "iGEM_Berlin", "NTNUigem", "BordeauxIGEM", "LethHS_iGEM", "uOttawaiGEM", "iGEM_SDU_", "GSU_iGEM", "LambertiGEM", "iGEM_Ciencias", "iGEMHZAU", "iGEM_Evry", "iGEMCopenhagen", "BostonU_iGEM", "TeamKentiGEM", "OUiGEM", "AlumniGEM", "iGEM_vlcCIPF", "CSIAiGEM", "iGEMAlberta", "GopheriGEM", "LethHSiGEM", "LeedsiGEM", "iGEMConcordia", "UCLAiGEM", "rosehulmaniGEM", "iGEM_York", "LiuiGem", "iGEM_UIUC", "iGEM_Toronto", "iGEM_Brunswick", "iGEMAachen", "WellesleyiGEM", "CAPSiGEM", "iGEM_Lyon", "ManchesteriGEM", "iGEMism", "iGEM_UGent", "iGEM_UniSalento", "manausiGEM", "ituigem", "igemBiwako", "iGEM_Paris", "Igemrandy", "iGEM_IIT_Delhi", "igem_heidelberg", "iGEM_TMU_TOKYO", "FDU_iGEM", "UtahState_iGEM", "iGEM_E_UAlberta", "iGEMWestminster", "WaterlooiGEMEnt", "UCDavisiGEM", "MaciGEM", "igemasia", "iGem_Frankfurt", "iGEM_Valencia", "igem_mn", "iGEM_THS", "PennStateiGEM20", "igembsas", "WashUiGEM", "Chalmers_iGEM", "iGEMTuebingen", "iGEMParisSaclay", "iGEM_NTNU", "iGEMExeter", "NRPiGEM", "iGEMVirginia", "iGEMLeicester", "iGEMGrenoble", "igembaskentmeds", "iGEM_KABK", "iGEMMX", "iGEMUIUC", "SciGEM", "igemE", "iGEMHighSchool", "GenoMX_iGEM", "iGEMEurope", "iGEMwatch", "iitdelhiigem", "iGEMPma", "iGemColombia", "igemwageningen", "iGEMTrieste", "UEAJIC_IGEM", "TUDelftiGEM", "iGEMStrathclyde", "GlasgowiGEM", "iGEM_Freiburg", "iGEMEdinburgh", "igemamsterdam", "Tsinghua_iGEM", "igem_hokkaidou", "iGEMUANL", "RutgersiGEM", "PennStateiGEM", "PenniGEM", "colombia_igem", "Brown_iGEM", "asuigem", "KULeuven_iGEM", "UWiGEM", "iGEM_KAIST", "iGEM_TUM", "zjuigem", "DundeeiGEMTeam", "MIT_iGEM", "iGEM__Osaka", "igemuppsala", "iGEMuOttawa", "iGEMGSU", "iGEM_Debrecen", "igemcanada", "UCLiGEM", "iGEM_UCSF", "LethbridgeiGEM", "iGEMupoSevilla", "StAndrewsiGEM", "iGEM_EPFL", "iGEM_NU", "StanfordiGEM", "igempanama", "iGEM_Bielefeld", "imperialigem", "iGEM_SDU", "ShefiGEM", "USTC_iGEM", "Waterloo_iGEM", "iGEMTecMty", "pavia_igem", "iGEMQueens", "igemstockholm", "igemtmu", "iGEMkyoto", "ubcigem", "harvardigem", "iGEMCalgary", "Cambridge_iGEM", "igembrasil", "iGEM_SupBiotech", "TUDelft_iGEM", "igemgroningen"]
i=0
for twitter in twitters:
    twitter=twitter.lower()
    twitter=twitter.replace("igem","")
    twitter=twitter.replace("_","")
    twitter=twitter.replace("team","")
    twitter=twitter.replace("2015","")
    
directory={}
directory["Aachen"]="@iGEMAachen"
directory["Amoy"]="@Amoy_igem"
directory["Amsterdam"]="@igemdam2015"
directory["ANU-Canberra"]="@anu_igem"
directory["BABS_UNSW_Australia"]="@UNSW_iGEM"
directory["Berlin"]="@iGEM_Berlin"
directory["BGU_Israel"]="@BGU_iGEM"
directory["Bielefeld-CeBiTec"]="@iGEM_Bielefeld"
directory["BIT-China"]="@iGEM_BIT"
directory["Bordeaux"]="@BordeauxIGEM"
directory["BostonU"]="@BostonU_iGEM"
directory["British_Columbia"]="@Columbia_iGEM X"
directory["Cambridge-JIC"]="@iGEMCambridge"
directory["Chalmers-Gothenburg"]="@Chalmers_iGEM"
directory["Columbia_NYC"]="@Columbia_iGEM"
directory["Concordia"]="@iGEMConcordia"
directory["Consort_Alberta"]="@iGEMAlberta"
directory["Cork_Ireland"]="@Cork_iGEM"
directory["CSU_Fort_Collins"]="@CSU_iGEM"
directory["DTU-Denmark"]="@iGEM_DTU"
directory["Dundee"]="@DundeeiGEMTeam"
directory["Edinburgh"]="@iGEMEdinburgh"
directory["ETH_Zurich"]="@ETH_iGEM"
directory["Evry"]="@iGEM_Evry_2015"
directory["Exeter"]="@ExeteriGEM2015"
directory["Freiburg"]="@iGEM_Freiburg"
directory["Gifu"]="@iGEMgifu"
directory["Glasgow"]="@2015iGEMglasgow"
directory["Goettingen"]="@iGEMGoe"
directory["Groningen"]="@igemgroningen"
directory["Harvard_BioDesign"]="@harvardigem"
directory["Heidelberg"]="@iGEMHeidelberg"
directory["HokkaidoU_Japan"]="@igem_hokkaidou"
directory["HZAU-China"]="@iGEMHZAU"
directory["IONIS_Paris"]="@IONIS_iGEM"
directory["Kent"]="@igem_kent"
directory["Leicester"]="@iGEMLeicester"
directory["Lethbridge"]="@LethbridgeiGEM"
directory["LZU-China"]="@igemlzu"
directory["Macquarie_Australia"]="@MaciGEM"
directory["Manchester-Graz"]="@ManchesteriGEM"
directory["Marburg"]="@iGEM_Marburg"
directory["METU_Turkey"]="@iGEM_METU15"
directory["MIT"]="@MIT_iGEM"
directory["Nagahama"]="@iGEM_Nagahama"
directory["NRP-UEA-Norwich"]="@NRPiGEM"
directory["Oxford"]="@OxfordiGEM"
directory["Paris_Bettencourt"]="@iGEM_Paris"
directory["Paris_Saclay"]="@iGEMParisSaclay"
directory["Pasteur_Paris"]="@iGEM_Pasteur"
directory["Peking"]="@iGEM_Peking"
directory["Penn"]="@PenniGEM"
directory["Pitt"]="@PittiGEM2015"
directory["Queens_Canada"]="@iGEMQueens"
directory["SDU-Denmark"]="@iGEMSDU2015"
directory["SJTU-Software"]="@igemsjtu"
directory["SPSingapore"]="@SPS_iGEM"
directory["Stanford-Brown"]="@StanfordiGEM"
directory["Stockholm"]="@igemstockholm"
directory["Sydney_Australia"]="@Sydney_iGEM"
directory["TAS_Taipei"]="@iGEM_TAS"
directory["Tianjin"]="@Tianjin_iGEM"
directory["Tokyo-NoKoGen"]="@iGEM_Nokogen"
directory["Toronto"]="@iGEM_Toronto"
directory["Toulouse"]="@toulouse_igem"
directory["Tsinghua"]="@Tsinghua_iGEM"
directory["Tuebingen"]="@iGEMTuebingen"
directory["TU_Darmstadt"]="@iGEM_Darmstadt"
directory["TU_Eindhoven"]="@Eindhoven_iGEM"
directory["UCL"]="@UCLiGEM"
directory["UCLA"]="@UCLAiGEM"
directory["UCSF"]="@iGEM_UCSF"
directory["UFMG_Brazil"]="@iGEMUFMG"
directory["UGA-Georgia"]="@UGA_iGEM_Team"
directory["UiOslo_Norway"]="@UiOslo_iGEM"
directory["UIUC_Illinois"]="@iGEM_UIUC"
directory["Uniandes_Colombia"]="@colombia_igem"
directory["UNIK_Copenhagen"]="@iGEMCopenhagen"
directory["UNITN-Trento"]="@iGEMTrento"
directory["uOttawa"]="@iGEMuOttawa"
directory["Uppsala"]="@igemuppsala"
directory["USTC"]="@USTC_iGEM"
directory["Valencia_UPV"]="@UPVigem"
directory["Vanderbilt"]="@Vanderbilt_iGEM"
directory["Vilnius-Lithuania"]="@Vilnius_iGEM"
directory["Virginia"]="@Virginia_iGEM"
directory["Warwick"]="@WarwickIGEM15"
directory["WashU_StLouis"]="@WashUiGEM"
directory["Waterloo"]="@Waterloo_iGEM"
directory["Wellesley_TheTech"]="@WellesleyiGEM"
directory["Westminster"]="@WestminsteriGEM"
directory["WPI-Worcester"]="@WPI_iGEM"
directory["Yale"]="@Yale_iGEM"
directory["York"]="@iGEMyork"
directory["ZJU-China"]="@zjuigem"

for entry in directory:
    if len([entry for entry_ in directory if directory[entry]==directory[entry_]])>1:
        print entry
        
f = open('teamsMatchmaking_1442154848.16.json','r')
teamsMatchmaking=json.load(f)
f.close()
        
print "# Tweets"
i=0
k=0
member=["Youssef","Marit","Julia","Madina"]
for entry in directory:
    if ((i % 25)==0):
        print "## %s" % member[k]
        k=k+1
    i=i+1
    recipient=directory[entry]
    match=[team["matchesMostHelpful"][0]["name"] for team in teamsMatchmaking if entry==team["name"]][0]
    if match in directory:
        message= "%s Your best #iGEM match is %s. More #iGEMMatchmaker results on http://snurl.com/2a7jtig?team=%s" % (directory[entry].replace("-Lithuania",""),directory[match],entry)
        if len(message)>140:
            raise Exception(message,len(message))
    else:
        message= "%s Your best #iGEM match is %s. More #iGEMMatchmaker results on http://snurl.com/2a7jtig?team=%s" % (directory[entry].replace("Colombia","").replace(" Australia",""),match,entry)
    if len(message)>140:
        raise Exception(message,len(message))
    #print directory[entry]
    print message
    print ""
    