### Noah Coomer
###
### 11/19/18
###
### db_populator

import pymysql


def create_follows(db, cursor, uids):
    n = len(uids)
    for i in range(n):
        count = 1
        ini = uids[i]
        idx = 0
        for j in range(10):
            try:
                idx = uids[i+count]
            except IndexError:
                count = 1
                idx = uids[count]
            count += 1
            #print(ini, idx)
            sql = "INSERT INTO Follows_User(user_id, following_id) VALUES('%d', '%d')" % (ini, idx)
            cursor.execute(sql)
            db.commit()


def create_comments(db, cursor, uids, tweets):
    n = len(uids)
    for i in range(n):
        count = 1
        idx = 0
        for j in range(3):
            try:
                idx = uids[i+count]
            except IndexError:
                count = 1
                idx = uids[count]
            count += 1
            tweet = tweets[i]
            text = ''
            if j == 0:
                text = 'Welcome to Twitter Clone!'
            elif j == 1:
                text = 'Great game last night.'
            else:
                text = 'Follow me!'
            sql = "INSERT INTO Comment(tweet_id, user_id, text) VALUES('%d', '%d', '%s')" % (tweet, idx, text)
            cursor.execute(sql)
            db.commit()


def create_likes(db, cursor, uids, tweets):
    n = len(uids)
    for i in range(n):
        count = 1
        idx = 0
        for j in range(5):
            try:
                idx = uids[i+count]
            except IndexError:
                count = 1
                idx = uids[count]
            count += 1
            tweet = tweets[i]
            sql = "INSERT INTO Likes(tweet_id, user_id) VALUES('%d', '%d')" % (tweet, idx)
            cursor.execute(sql)
            db.commit()



def create_tweets(db, cursor, uids):
    for key, value in uids.items():
        string = "Hi everyone! My name is %s and I just joined TwitterClone." % value
        sql = "INSERT INTO Tweet(user_id, text) VALUES('%d', '%s')" % (int(key), string)
        cursor.execute(sql)
        db.commit()


def graph_tweets(file, uids):
    counter = 1
    for key, value in uids.items():
        string = "Hi everyone! My name is %s and I just joined TwitterClone." % value
        id = "u" + key
        tw_id = "t" + str(counter)
        cypher = "CREATE (%s:Tweet {text:'%s',date_created:'12032018'})\n" % (tw_id, string)
        file.write(cypher)
        rel = "CREATE (%s)-[:PUBLISHES]->(%s)\n" % (id, tw_id)
        file.write(rel)
        counter += 1


def graph_likes(file, uids, tweets):
    n = len(uids)
    for i in range(n):
        count = 1
        idx = 0
        for j in range(5):
            try:
                idx = 'u' + str(uids[i+count])
            except IndexError:
                count = 1
                idx = 'u' + str(uids[count])
            count += 1
            tweet = 't' + str(tweets[i])
            cypher = "CREATE (%s)-[:LIKES]->(%s)\n" % (idx, tweet)
            file.write(cypher)


def graph_follows(file, uids):
    n = len(uids)
    for i in range(n):
        count = 1
        ini = "u" + str(uids[i])
        idx = 0
        for j in range(10):
            try:
                idx = "u" + str(uids[i+count])
            except IndexError:
                count = 1
                idx = "u" + str(uids[count])
            count += 1
            #print(ini, idx)
            #sql = "INSERT INTO Follows_User(user_id, following_id) VALUES('%d', '%d')" % (ini, idx)
            cypher = "CREATE (%s)-[:FOLLOWS{date_created: '12042018'}]->(%s)\n" % (ini, idx)
            file.write(cypher)


def graph_comments(file, uids, tweets):
    n = len(uids)
    counter = 1
    for i in range(n):
        count = 1
        idx = 0
        for j in range(3):
            try:
                idx = 'u' + str(uids[i+count])
            except IndexError:
                count = 1
                idx = 'u' + str(uids[count])
            count += 1
            tweet = 't' + str(tweets[i])
            text = ''
            if j == 0:
                text = 'Welcome to Twitter Clone!'
            elif j == 1:
                text = 'Great game last night.'
            else:
                text = 'Follow me!'
            #sql = "INSERT INTO Comment(tweet_id, user_id, text) VALUES('%d', '%d', '%s')" % (tweet, idx, text)
            comment_id = 'c' + str(counter)
            cypher = "CREATE (%s:Comment{text:'%s', date_created:'12042018'})\n" % (comment_id, text)
            file.write(cypher)
            rel_a = "CREATE (%s)-[:MAKES_COMMENT]->(%s)\n" % (idx, comment_id)
            file.write(rel_a)
            rel_b = "CREATE (%s)-[:HAS_COMMENT]->(%s)\n" % (tweet, comment_id)
            file.write(rel_b)
            counter += 1


def get_uids_names_dict(cursor):
    uids = {}
    sql = "SELECT DISTINCT id, fname, lname FROM User"
    cursor.execute(sql)
    for row in cursor:
        uids[str(row['id'])] = row['fname'] + ' ' + row['lname']
    return uids

def get_tweets_arr(cursor):
    tweets = []
    sql = "SELECT tweet_id FROM Tweet"
    cursor.execute(sql)
    for row in cursor:
        tweets.append(row['tweet_id'])
    return tweets

def get_uids_arr(cursor):
    uids = []
    sql = "SELECT id FROM User"
    cursor.execute(sql)
    for row in cursor:
        uids.append(row['id'])
    return uids


def main():
    db = pymysql.connect("localhost", "root", "britton11", "TwitterClone")
    cursor = db.cursor(pymysql.cursors.DictCursor)

    #uids = get_uids_names_dict(cursor)
    uids = get_uids_arr(cursor)
    tweets = get_tweets_arr(cursor)
    #create_tweets(db, cursor, uids)
    file = open('../db/neo4j_comments.txt', 'w')
    #graph_tweets(file, uids)
    #graph_likes(file, uids, tweets)
    #graph_follows(file, uids)
    graph_comments(file, uids, tweets)
    file.close()


    #uids = get_uids_arr(cursor)
    #create_likes(db, cursor, uids, tweets)
    #create_comments(db, cursor, uids, tweets)

    #uids = get_uids_arr(cursor)
    #create_follows(db, cursor, uids)

    db.close()


main()