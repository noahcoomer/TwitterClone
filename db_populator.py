### Noah Coomer
###
### 11/19/18
###
### db_populator

import pymysql


def create_follows():
    print()


def create_comments():
    print()


def create_likes():
    print()


def create_tweets(db, cursor, uids):
    for key, value in uids.items():
        string = "Hi everyone! My name is %s and I just joined TwitterClone." % value
        sql = "INSERT INTO Tweet(user_id, text) VALUES('%d', '%s')" % (int(key), string)
        cursor.execute(sql)
        db.commit()


def get_uids_names_dict(cursor):
    uids = {}
    sql = "SELECT DISTINCT id, fname, lname FROM User"
    cursor.execute(sql)
    for row in cursor:
        uids[str(row['id'])] = row['fname'] + ' ' + row['lname']
    return uids


def main():
    db = pymysql.connect("localhost", "root", "britton11", "TwitterClone")
    cursor = db.cursor(pymysql.cursors.DictCursor)
    uids = get_uids_names_dict(cursor)
    create_tweets(db, cursor, uids)

    db.close()


main()