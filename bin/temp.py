#!/usr/bin/env python3

import logging
import os
import MySQLdb as mariadb

from sense_hat import SenseHat
from time import sleep, strftime
from datetime import datetime
from dotenv import load_dotenv, find_dotenv

TEMPERATURE_OFFSET = 13

def get_temperature(sense):
    return sense.get_temperature() - TEMPERATURE_OFFSET

def update_database(db, temperature):
    cursor = db.cursor()

    statement = """
    INSERT INTO coldroomtemperatures(ColdRoomSensorNumber, RecordedWhen, Temperature, ValidFrom, ValidTo)
    VALUES(%s, %s, %s, %s, %s)
    """
    values = (1, datetime.now(), temperature, datetime.now(), '9999-12-31 23:59:59')
    try:
        cursor.execute(statement, values)
        db.commit()
    except Exception as err:
        logging.error(f'Could not insert temperature into database: {err}')

    logging.info(f'Inserted temperature {temperature} into database')

def archive_temperature(db):
    cursor = db.cursor()
    statement = """
    UPDATE coldroomtemperatures SET ValidTo = %s;
    """
    date = strftime('%Y-%m-%d %H:%M:%S')
    cursor.execute(statement, (date,))
    statement = """
    INSERT INTO coldroomtemperatures_archive (SELECT * FROM coldroomtemperatures);
    """
    cursor.execute(statement)
    statement = """
    DELETE FROM coldroomtemperatures;
    """
    cursor.execute(statement)
    try:
        db.commit()
    except Exception as err:
        logging.error(f'Could not archive temperatures: {err}')


    logging.info('Archived temperatures')

def main():
    load_dotenv(find_dotenv())
    logging.basicConfig(level=logging.INFO)

    sense = SenseHat()
    try:
        db = mariadb.connect(
            host='nerdygadgets.shop',
            port=33646,
            user='nerd',
            password=os.getenv('DB_PASSWORD'),
            database='nerdygadgets'
        )
    except Exception as err:
        logging.error(f'Could not connect to database: {err}')
        exit(1)

    while True:
        archive_temperature(db)
        update_database(db, get_temperature(sense))
        sleep(3)

    db.close()

if __name__ == '__main__':
    main()
