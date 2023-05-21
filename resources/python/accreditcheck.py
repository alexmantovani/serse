import sys
import os
from dataclasses import dataclass
import hashlib
from datetime import datetime
from datetime import timedelta
# from tkinter.messagebox import NO
import uuid
import zipfile
import tempfile
import json


uuidAccredit = [0x09, 0x03, 0x01, 0x0A, 0x1C, 0x2D, 0xB1,
                0x3E, 0xAC, 0x7A, 0x11, 0x3F, 0xCC, 0xE3, 0x44, 0x59]


@dataclass
class Accredit:
    userName: str = ""
    userID: str = ""
    format: str = ""
    machine: str = ""
    accountLevel: int = 0
    accountState: int = 0
    accountExpiry: int = 0
    accountSince: int = 0
    accountUntil: int = 0
    accreditLife: int = 0
    PIN_0: int = 0
    PIN_1: int = 0
    PIN_2: int = 0
    PIN_3: int = 0
    pin: str = ""


def logga(*a):
    # print(*a)
    pass


def write_raw_data(testo, length=128):
    output_string = bytearray(testo, 'utf-8')
    for i in range(len(testo), length):
        output_string += b'\x00'
    return output_string


def write_qvariant_item(key, value, type):
    # Scrivo la chiave
    output_string = (len(key) * 2).to_bytes(4, byteorder='little')
    output_string += bytearray(key, 'utf-16')[2:]
    if type == 'Str':
        # Scrivo il tipo
        output_string += (10).to_bytes(5, byteorder='little')
        # Scrivo il valore
        output_string += (len(value) * 2).to_bytes(4, byteorder='little')
        if len(value) > 0:
            output_string += bytearray(value, 'utf-16')[2:]
        else:
            pass
    elif type == 'Int':
        # Scrivo il tipo
        output_string += (2).to_bytes(5, byteorder='little')
        # Scrivo il valore
        output_string += (int(value)).to_bytes(4, byteorder='little')
    elif type == 'LongLong':
        output_string += (5).to_bytes(5, byteorder='little')
        output_string += (value).to_bytes(8, byteorder='little')
    else:
        logga(f"Tipo sconosciuto {type}")

    return output_string


# Tipi di dati contenuti nelle QVariant (./qt/src/corelib/kernel/qvariant.h)
# Invalid = 0,
# Bool = 1,
# Int = 2,
# UInt = 3,
# LongLong = 4,
# ULongLong = 5,
# Double = 6,
# Char = 7,
# Map = 8,
# List = 9,
# String = 10,
# StringList = 11,
# ByteArray = 12,
# BitArray = 13,
# Date = 14,
# Time = 15,
# DateTime = 16,
# Url = 17,
# Locale = 18,
# ...
def parserizza_qmap(data):
    result = {}

    # index = 0
    # logga(f'STRANO {int.from_bytes(data[index:index + 4], "little")}')
    index = 4
    while index < len(data):
        str_len = int.from_bytes(data[index:index + 4], "little")
        chiave = data[index + 4:index + 4 + str_len].decode('utf-16')
        index = index + 4 + str_len
        tipo = int.from_bytes(data[index:index + 5], "little")
        # valore = 0
        index += 4
        index += 1  # TODO: Questo +1 FONDAMENTALE andrebbe indagato
        # tipo_str = ""
        # logga(f"{str_len} {chiave} {tipo}")
        if tipo == 2:
            tipo_str = "Int"
            valore = int.from_bytes(data[index:index + 4], "little")
            index += 4
        elif tipo == 5:
            tipo_str = "LongLong"
            valore = int.from_bytes(data[index:index + 8], "little")
            index += 8
        elif tipo == 10:
            tipo_str = "Str"
            value_len = int.from_bytes(data[index:index + 4], "little")
            index += 4
            if value_len == 0:
                valore = ""
            else:
                valore = data[index:index + value_len].decode('utf-16')
                index = index + value_len
            # logga(f"Value len {value_len}")
        elif tipo == 0:
            break
        else:
            logga(f"ESCO!!! tipo sconosciuto: {tipo}")
            break

        result[chiave] = valore

        logga(f"{chiave} => '{valore}' : {tipo_str}")
    logga(f"=====================")

    return result


def read_accredit_ed2(file_name):
    with open(file_name, "rb") as file:
        buf = file.read()

    if (len(buf) & 3):
        logga(f"LEN FAIL!!! len={len(buf)}")
        return None

    ed_key = [0x49, 0x6b, 0x52, 0xa7]
    array = []
    index = 0
    for k in range(len(buf)):
        array.append(buf[k] ^ ed_key[k % 4])
        # array.append(buf[k])

    byte_array = bytearray(array)

    marker = int.from_bytes(byte_array[0:4], byteorder='little')
    if marker != 0x41434352:
        logga("MARKER FAIL!!!")
        return None

    ofs = int.from_bytes(byte_array[4:8], byteorder='little')
    if ofs + 8 > len(buf):
        logga(f"OFFSET FAIL!!! len{len(buf)} != ofs{ofs}")
        return None

    # logga(byte_array)

    final_marker = int.from_bytes(byte_array[ofs:ofs + 4], byteorder='little')
    if final_marker != 0x61636372:
        logga(f"FINAL MARKER FAIL!!! {ofs} ({byte_array[ofs-8:ofs + 8]})")

        # guardo se è fuori posto
        for i, val in enumerate(byte_array):
            if val == 0x72:
                logga(i)
        return None

    cks = 0
    for k in range(ofs - 8):
        cks += byte_array[k+8]

    cks_compara = int.from_bytes(
        byte_array[ofs + 4:ofs + 8], byteorder='little')
    if cks != cks_compara:
        logga(
            f"CKS FAIL!!! {hex(cks)} != {cks_compara} delta {cks_compara-cks}    {byte_array[ofs :ofs + 8]}")
        logga(
            f"{hex(byte_array[ofs + 4])} {hex(byte_array[ofs + 5])} {hex(byte_array[ofs + 6])} {hex(byte_array[ofs + 7])} ")
        return None

    result = parserizza_qmap(byte_array[8:8 + ofs])
    if len(result.keys()) == 0:
        return None

    result['hmi'] = "ed2"

    return result


def create_accredit_ed2(username, user_id, pin='0000', machine='all', account_level="7", account_state=0, duration="7"):
    uuid_int = int(uuid.uuid4().hex[0:16], 16)
    from_date = int(datetime.timestamp(datetime.now()))
    to_date = int(datetime.timestamp(
        datetime.now() + timedelta(days=int(duration))))
    md5 = hashlib.md5(bytearray(str(pin), 'utf-8')).digest()
    pin_0 = int.from_bytes(md5[0:8], "little", signed=False)
    pin_1 = int.from_bytes(md5[8:16], "little", signed=False)

    level = 100
    if account_level == "6":
        level = 3

    accredit = []
    accredit.append({'key': 'uuid', 'value': uuid_int, 'type': 'LongLong'})
    accredit.append({'key': 'username', 'value': username, 'type': 'Str'})
    accredit.append({'key': 'userid', 'value': user_id, 'type': 'Str'})
    accredit.append({'key': 'from', 'value': from_date, 'type': 'Int'})
    accredit.append({'key': 'to', 'value': to_date, 'type': 'Int'})
    accredit.append({'key': 'password', 'value': '', 'type': 'Str'})
    accredit.append({'key': 'machine', 'value': machine, 'type': 'Str'})
    accredit.append({'key': 'md5', 'value': pin_0 ^ pin_1, 'type': 'LongLong'})
    accredit.append({'key': 'level', 'value': level, 'type': 'Int'})
    accredit.append({'key': 'format', 'value': 'all', 'type': 'Str'})
    accredit.append({'key': 'duration', 'value': 0, 'type': 'Int'})
    accredit.append({'key': 'accountduration',
                    'value': int(duration)*24, 'type': 'Int'})

    return accredit


def write_accredit_ed2(file_name, accredit):
    # Qui metto tutte le info
    info: bytes = b''
    # TODO: DA CAPIRE cosa significa 12
    info += (12).to_bytes(4, byteorder='little')
    for item in accredit:
        info += write_qvariant_item(**item)

    # Preparo lo stream da mandare
    final: bytes = b''
    final += (0x41434352).to_bytes(4, byteorder='little')
    final += (len(info)+8).to_bytes(4, byteorder='little')  # offset
    final += info
    final += (0x61636372).to_bytes(4, byteorder='little')  # Merker finale

    # Calcolo la checksum
    cks = 0
    for k in range(len(info)):
        cks = cks + info[k]
    final += (cks).to_bytes(4, byteorder='little')

    n = len(final) & 3
    for i in range(4 - n):
        final += b'\x00'

    # Lo cifro
    ed_key = [0x49, 0x6b, 0x52, 0xa7]
    array = []
    index = 0
    for k in range(len(final)):
        array.append(final[k] ^ ed_key[k % 4])
        # array.append(final[k])

    byte_array = bytearray(array)

    with open(file_name, "wb") as file:
        file.write(byte_array)


def read_accredit(file_name) -> Accredit:
    with open(file_name, "rb") as file:
        md5Read = file.read(16)
        buf = file.read()

    array = []
    for k in range(len(buf)):
        array.append(buf[k] ^ uuidAccredit[k % 16])

    byte_array = bytearray(array)
    md5Calc = hashlib.md5(byte_array).digest()

    for i in range(4):
        if md5Read[i] != md5Calc[i]:
            logga("FAIL!!!")
            return None

    accredit = Accredit()
    accredit.userName = byte_array[0:128].decode("utf-8").rstrip("\x00")
    accredit.userID = byte_array[128:256].decode("utf-8").rstrip("\x00")
    accredit.format = byte_array[256:384].decode("utf-8").rstrip("\x00")
    accredit.machine = byte_array[384:512].decode("utf-8").rstrip("\x00")

    accredit.accountLevel = int.from_bytes(
        byte_array[512:516], byteorder='big', signed=True)
    accredit.accountState = int.from_bytes(
        byte_array[516:520], byteorder='big', signed=True)
    accredit.accountExpiry = int.from_bytes(
        byte_array[520:524], byteorder='big', signed=True)
    accredit.accountSince = int.from_bytes(
        byte_array[524:528], byteorder='big', signed=True)
    accredit.accountUntil = int.from_bytes(
        byte_array[528:532], byteorder='big', signed=True)
    accredit.accreditLife = int.from_bytes(
        byte_array[532:536], byteorder='big', signed=True)
    # PIN
    accredit.PIN_0 = int.from_bytes(
        byte_array[536:540], "little", signed=False)
    accredit.PIN_1 = int.from_bytes(
        byte_array[540:544], "little", signed=False)
    accredit.PIN_2 = int.from_bytes(
        byte_array[544:548], "little", signed=False)
    accredit.PIN_3 = int.from_bytes(
        byte_array[548:552], "little", signed=False)

    # return accredit

    result = {}

    result['username'] = accredit.userName
    result['userid'] = accredit.userID
    result['machine'] = accredit.machine
    result['format'] = accredit.format
    result['level'] = accredit.accountLevel
    result['from'] = accredit.accountSince
    result['to'] = accredit.accountExpiry
    result['hmi'] = "ed1"

    return result


def print_accredit(accredit):
    print(accredit.userName)
    print(accredit.userID)
    print(accredit.format)
    print(accredit.machine)
    print(accredit.accountLevel)
    print(accredit.accountState)
    print(accredit.accountExpiry)
    print(f"{datetime.fromtimestamp(accredit.accountSince)}")
    print(accredit.accreditLife)
    print(f"{hex(accredit.PIN_0)} {hex(accredit.PIN_1)} {hex(accredit.PIN_2)} {hex(accredit.PIN_3)}")


def write_accredit(file_name, accredit: Accredit):
    final = b''
    final += write_raw_data(accredit.userName, 128)
    final += write_raw_data(accredit.userID, 128)
    final += write_raw_data(accredit.format, 128)
    final += write_raw_data(accredit.machine, 128)
    final += (accredit.accountLevel).to_bytes(4, byteorder='big')  # level
    final += (0).to_bytes(4, byteorder='big')  # status
    final += (accredit.accountExpiry).to_bytes(4, byteorder='big')
    final += (accredit.accountSince).to_bytes(4, byteorder='big')
    final += (accredit.accountUntil).to_bytes(4, byteorder='big')
    final += (accredit.accreditLife).to_bytes(4, byteorder='big')
    # PIN
    final += (accredit.PIN_0).to_bytes(4, byteorder='little', signed=False)
    final += (accredit.PIN_1).to_bytes(4, byteorder='little', signed=False)
    final += (accredit.PIN_2).to_bytes(4, byteorder='little', signed=False)
    final += (accredit.PIN_3).to_bytes(4, byteorder='little', signed=False)

    md5Calc = hashlib.md5(final).digest()

    array = []
    for k in range(len(md5Calc)):
        array.append(md5Calc[k])
    for k in range(len(final)):
        array.append(final[k] ^ uuidAccredit[k % 16])

    byte_array = bytearray(array)

    with open(file_name, "wb") as file:
        file.write(byte_array)


# account_level 7=superuser 6=format admin
def create_accredit(username, user_id, pin='0000', machine='all', account_level="7", account_state=0, duration=7):
    accredit = Accredit()
    accredit.userName = username
    accredit.userID = user_id
    accredit.format = 'all'
    accredit.machine = machine

    accredit.accountLevel = int(account_level)
    accredit.accountState = account_state

    now = datetime.now()
    timestamp = int(datetime.timestamp(now))

    accredit.accountExpiry = int(duration) * 24  # Una settimana

    accredit.accountSince = timestamp
    accredit.accountUntil = timestamp + int(accredit.accountExpiry) * 3600
    accredit.accreditLife = 2  # 2 ore

    # Calcolo il PIN
    md5 = hashlib.md5(bytearray(str(pin), 'utf-8')).digest()

    accredit.PIN_0 = int.from_bytes(md5[0:4], "big", signed=False)
    accredit.PIN_1 = int.from_bytes(md5[4:8], "big", signed=False)
    accredit.PIN_2 = int.from_bytes(md5[8:12], "big", signed=False)
    accredit.PIN_3 = int.from_bytes(md5[12:16], "big", signed=False)

    return accredit


def zippa_accredito(temp_dir, dest_file):
    with zipfile.ZipFile(dest_file, mode='w') as myzip:
        for entry in os.listdir(temp_dir):
            filename = os.path.join(temp_dir, entry)
            myzip.write(filename, entry)


def leggi_accrediti(basepath="./"):
    for entry in os.listdir(basepath):
        filename = os.path.join(basepath, entry)
        if os.path.isfile(filename):
            if filename.endswith(".accr"):
                read_accredit_ed2(filename)
        if os.path.isdir(filename):
            leggi_accrediti(os.path.join(basepath, entry))


if len(sys.argv) != 2:
    logga(f"Parametri errati")
    logga(
        f"{sys.argv[0]} <path file name>")
    exit(11)

accred = read_accredit(sys.argv[1])
if accred is None:
    accred = read_accredit_ed2(sys.argv[1])

if accred is None:
    exit(1)

with open(sys.argv[1] + '.json', 'w') as fp:
    json.dump(accred, fp)

exit(0)
