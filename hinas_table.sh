#!/bin/bash

# 修改文件夹权限
chmod 777 /var/www/html/icons_wan/
chmod 777 /var/www/html/icons_lan/
chmod 777 /var/www/html/img/png/

# 下载文件到指定目录
download_file() {
    url=$1
    directory=$2
    
    filename=$(basename "$url")
    destination="$directory/$filename"
    
    if [ -e "$destination" ]; then
        read -p "文件 '$filename' 已存在于目标目录中。是否覆盖？(y/n): " choice
        if [ "$choice" != "y" ]; then
            echo "取消下载 '$filename' 到 '$directory'"
            return
        fi
    fi
    
    echo "正在下载 '$filename' 到 '$directory' ..."
    wget -q "$url" -O "$destination"
    echo "已完成下载 '$filename'"
}

# 下载文件
download_file "http://s6oqp1a2c.hn-bkt.clouddn.com/add.png" "/var/www/html/img/png"
download_file "http://s6oqp1a2c.hn-bkt.clouddn.com/controller.php" "/var/www/html"
download_file "http://s6oqp1a2c.hn-bkt.clouddn.com/index.html" "/var/www/html"
