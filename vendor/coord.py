import pandas as pd
import joblib
import sys

kmeans = joblib.load('titude_model.pkl')

longitude = sys.argv[1]
latitude = sys.argv[2]

input_data = pd.DataFrame([[longitude, latitude]], columns=['longitude', 'latitude'])

cluster = int(kmeans.predict(input_data)[0])

print(cluster, end='')