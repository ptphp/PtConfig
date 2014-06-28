#!/bin/sh
redis_host="127.0.0.1"
redis_port="6379"

for data in 100 200; do
    for client in 100 200; do
        for num in 5000 1000; do
            echo "redis-benchmark -q -h $redis_host -p $redis_port -c $client -n $num -d $data ";
        done
    done
done
