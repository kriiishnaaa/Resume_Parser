import mysql.connector
host='localhost'
password=''
user='root'
dbname='database'
connection=mysql.connector.connect(
    host=host,
    user=user,
    password=password,
    database=dbname
)
cursor=connection.cursor()
data={
    'name':'john',
    'age':18,
    'city':'california',
    'email':'john@gmail.com'
}
query="insert into trial({}) values ({})".format(', '.join(data.keys()),', '.join(['%s']*len(data)))
data_list=list(data.values())
cursor.execute(query,data_list)
connection.commit()
cursor.close()
connection.close()
