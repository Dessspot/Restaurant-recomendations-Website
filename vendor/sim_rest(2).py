import pandas as pd
import joblib
import sys
import numpy as np
import psycopg2
import json


conn = psycopg2.connect(user="Alikhan",
                        password="Alikh001231550246",
                        host="localhost",
                        port="1234",
                        database="course")
cursor = conn.cursor()
# business_id = '7UOJofNZSY6pQkIk6QUOGA'
business_id = sys.argv[1]
knn = joblib.load('sim_rest.pkl')

cursor.execute(f"SELECT * from sim_rest where business_id = '{business_id}'")

rest_all = cursor.fetchall()

# print(rest_all)
columns = [desc[0].lower() for desc in cursor.description]  # Convert column names to lowercase
df = pd.DataFrame(rest_all, columns=columns)


df = df.iloc[:, :-4]

distances, indices = knn.kneighbors(df)

# result = np.column_stack((distances.flatten(), indices.flatten()))
result = indices.flatten()
result_json = json.dumps(result.tolist())

print(result_json , end='')