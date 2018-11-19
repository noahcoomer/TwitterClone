### Noah Coomer
###
### 2018 NBA Players API Poller
###
### root url: http://data.nba.net/10s/prod/v1/today.json
### players url: http://data.nba.net/10s/prod/v1/2018/players.json

import json
from urllib.request import urlopen
import pymysql
import csv


### connect to the nba api
def connect(url):
    print("Making connection to", url)
    data = urlopen(url)
    string = data.read().decode('utf-8')
    ret = json.loads(string)
    print("Data payload received")
    return ret


### write the player api data to a .csv file
def write_players(file, data):
    print("Writing data")
    file.write('id,fname,lname,teamId,yob,jersey,active,position,height\n')
    players = data['league']['standard']
    count = 1
    for player in players:
        try:
            file.write(player['personId'] + ',' + player['firstName'] + ',' + player['lastName'] + ',' +
                       player['teams'][0]['teamId'] + ',' + player['dateOfBirthUTC'][:4] + ',' + player['jersey'] + ',' +
                       str(player['isActive']) + ',' + player['pos'] + ',' + player['heightFeet'] + '\'' + player['heightInches'] +'\"' + '\n')
            count += 1
        except IndexError:
            continue
    print("Finished writing data")


### write the team api data to a .csv file
def write_teams(file, data):
    print("Writing team data")
    file.write('id,tricode,city,teamName,fullName,franchise,conference,division\n')
    teams = data['league']['standard']
    for team in teams:
        file.write(team['teamId'] + ',' + team['tricode'] + ',' + team['city'] + ',' + team['nickname'] + ',' + team['fullName'] + ',' +
                   str(team['isNBAFranchise']) + ',' + team['confName'] + ',' + team['divName'] + '\n')
    print("Finished writing data")


def write_schedule(file, data):
    print("Writing schedule data")
    games = data['league']['standard']
    file.write('id,url,startDate,type,homeTeam,homeScore,homeWins,homeLosses,awayTeam,awayScore,awayWins,awayLosses\n')
    for game in games:
        text = game['nugget']['text']
        text = text.replace(',', ';')
        # strip the text of commas
        # add the tag so there are game distinctions
        file.write(game['gameId'] + ',' + game['gameUrlCode'] + ',' + game['startDateEastern'] + ',' + text +
                   ',' + game['hTeam']['teamId'] + ',' + game['hTeam']['score'] + ',' + game['hTeam']['win'] + ',' +
                   game['hTeam']['loss'] + ',' + game['vTeam']['teamId'] + ',' + game['vTeam']['score'] + ',' +
                   game['vTeam']['win'] + ',' + game['vTeam']['loss'] + '\n')
    print("Finished writing data")


### form a dictionary with team id's as the keys and the full name as the values
def form_teams_dict(team_reader):
    teams = {}
    for row in team_reader:
        team_id = str(row['id'])
        team_name = row['fullName']
        teams[team_id] = team_name
    return teams


### iterate through the data and write to db
def database_transfer(db, cursor, reader, teams):
    for row in reader:
        players_transfer(db, cursor, row, teams)


def players_transfer(db, cursor, row, teams):
    # get necessary information
    id = int(row['id'])
    fname = row['fname']
    fname = fname.replace('\'', '')
    lname = row['lname']
    lname = lname.replace('\'', '')
    team_id = str(row['teamId'])
    team = teams[team_id]

    jersey = row['jersey']
    position = row['position']
    height = row['height']
    password = 'password'
    yob = int(row['yob'])

    # form the email
    variation = False
    email = fname.lower() + '_' + lname.lower() + '@gmail.com'
    username = fname + lname + str(jersey)

    bio = "Hi, my name is " + fname + " " + lname + ". I play for the " + team + " in the " + position + " position."
    print(bio)


    try:
        sql = "INSERT INTO User(id, email, password, username, fname, lname, bio, yob) \
               VALUES('%d', '%s', '%s', '%s', '%s', '%s', '%s', '%d')" % (id, email, password, username, fname, lname, bio, yob)
        cursor.execute(sql)
        db.commit()
        print(sql)

    except pymysql.InternalError as e:
        print(e.args[0])
        print("Error: aborting operation on line: ")
        print(fname, lname)
        db.rollback()
        return

def main():
    #player_url = 'http://data.nba.net/10s/prod/v1/2018/players.json'
    #team_url = 'http://data.nba.net/10s/prod/v2/2018/teams.json'
    #schedule_url = 'http://data.nba.net/10s/prod/v1/2018/schedule.json'
    #data = connect(team_url)
    #data = connect(schedule_url)

    #file = open('csv/schedule.csv', 'w')
    #write_schedule(file, data)
    #file.close()

    ### write the teams to a .csv file
    #file = open('csv/teams.csv', 'w')
    #write_teams(file, data)
    #file.close()

    ### write the players to a .csv file
    #file = open('csv/players.csv', 'w')
    #write_players(file, data)
    #file.close()

    ### create the teams dictionary
    file = open('csv/teams.csv', 'r')
    team_reader = csv.DictReader(file)
    teams = form_teams_dict(team_reader)
    file.close()


    ### transfer the players to the database
    db = pymysql.connect("localhost", "root", "britton11", "TwitterClone")
    cursor = db.cursor()
    csvfile = open('csv/players.csv', 'r')
    reader = csv.DictReader(csvfile)
    database_transfer(db, cursor, reader, teams)
    db.close()
    csvfile.close()


main()
