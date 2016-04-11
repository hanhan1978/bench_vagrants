# Setting 周り

/etc/security/limits.conf

```
* hard nofile 65535
* soft nofile 65535
```

/etc/sysctl.conf
sudo /sbin/sysctl -p

```
net.ipv4.tcp_max_tw_buckets = 2000000
net.ipv4.ip_local_port_range = 10000 65000
net.core.somaxconn = 32768
net.core.netdev_max_backlog = 8192
net.ipv4.tcp_tw_reuse = 1
net.ipv4.tcp_fin_timeout = 10
```

/etc/nginx.conf

```
worker_processes 1 => 2;
worker_connections 256 => 2048;
```

ローカルのMac
sudo launchctl limit maxfiles 8192 8192

# Nginx FastCGI

## CPU 2, Memory 2048MB

```
siege -q -c610 -r30 -f urls.txt
```

```
Transactions:                  18300 hits
Availability:                 100.00 %
Elapsed time:                  39.39 secs
Data transferred:            1101.22 MB
Response time:                  0.49 secs
Transaction rate:             464.58 trans/sec
Throughput:                    27.96 MB/sec
Concurrency:                  226.85
Successful transactions:       18300
Failed transactions:               0
Longest transaction:           11.83
Shortest transaction:           0.00
```

# Apache FastCGI 

## memo
defaultでmax open filesは 8192 /proc/{pid}/limits で確認

## CPU 2, Memory 2048MB


```
Transactions:                  19500 hits
Availability:                 100.00 %
Elapsed time:                  54.57 secs
Data transferred:            1105.46 MB
Response time:                  0.85 secs
Transaction rate:             357.34 trans/sec
Throughput:                    20.26 MB/sec
Concurrency:                  305.23
Successful transactions:       19500
Failed transactions:               0
Longest transaction:           24.91
Shortest transaction:           0.00
```
