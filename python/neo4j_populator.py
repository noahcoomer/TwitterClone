def create_likes(db, cursor, uids, tweets):
    n = len(uids)
    id_counter = 0
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
            cypher = "CREATE ('%d':Like {tweet_id: '%d', user_id: '%d'})" % (id_counter)
            cursor.execute(sql)
            db.commit()


def main():
    print()


main()