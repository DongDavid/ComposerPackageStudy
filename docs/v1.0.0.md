# 扩展包发布-学习记录  


首先安装一个快速构建包结构的工具

```
composer global require "overtrue/package-builder" --prefer-source
```

>小知识 `--prefer-dist`会从github上下载zip压缩包，并缓存到本地,但是它没有保留.git文件夹,没有版本信息。  
`--prefer-source`会从github上clone源码,不会在本地缓存。但它保留了.git文件夹。

## 新建扩展包目录  


```sh
package-builder build ./wheather
```

创建成功后的目录为  

```
├── readme.md
└── weather
    ├── composer.json
    ├── .editorconfig
    ├── .gitattributes
    ├── .gitignore
    ├── .php_cs
    ├── phpunit.xml.dist
    ├── README.md
    ├── src
    │   └── .gitkeep
    └── tests
        └── .gitkeep
```

## 接入高德天气  

注册高德开发者账号  
新建一个应用并获取key  



## 开始开发  

### 声明自动加载   

修改`composer.json`文件

```
"autoload": {
    "psr-4": {
        "Dongdavid\\Weather\\": "src"
    }
}
```

执行`composer dump-autoload`更新

### 引入HTTP客户端  

`composer require guzzlehttp/guzzle`


### 编写单元测试  


编写好测试类  

在终端中执行 调用测试类`testGetWeatherWithInvalid`
```
$ ./vendor/bin/phpunit --filter testGetWeatherWithInvalid
```
它会执行以`WeatherTest`中`testGetWeatherWithInvalid`开头的方法


执行所有的测试方法
```
$ ./vendor/bin/phpunit
```

## 进行完整测试  

另外新建一个空的项目  

```sh
mkdir weather-test
cd weather-test
# 初始化一下 随便填
composer init
# 配置刚才完成的包的路径,用于本地加载
composer config repositories.weather path ../weather
# 引入扩展包  这里  `dev-master`  中的 dev 指该分支下最新的提交，master 是指定的包中的分支名
composer require dongdavid/weather:dev-master
```

以本地库的形式引入的包,并不会把包拷贝到当前项目的vendor目录中,而是以软链接的形式引用的。
所以此时你修改本地库中的文件时,当前项目引用的文件也会跟着变  

```json
"repositories": {
	"weather": {
	    "type": "path",
	    "url": "../weather"
	}
}
```
```sh
$ ll vendor/dongdavid/weather
lrwxrwxrwx 1 ddv ddv 16 Jul  7 21:32 vendor/dongdavid/weather -> ../../../weather/
```

## 编写文档  

一份友好的文档应该包含下面这些信息：  

* 项目简介及创作动机
* 项目维护、CI、依赖更新状态（如果有）
* features & 适用人群
* 运行的平台或硬件要求
* 重要依赖
* 如何安装与测试
* 使用示例及文档地址
* 贡献指南
* License
* 鸣谢
* 其它特有的信息

### 问题1:此时报错提示命令不存在

```sh
$ package-builder build ./weather
package-builder: command not found
```

#### 处理方式

1. 使用绝对路径调用  
	
	`~/.config/composer/vendor/bin/package-builder build ./weather`

2. 将全局安装的脚本类文件加入到环境变量中

	修改`~/.bashrc`文件,在末尾追加
	`PATH="~/.config/composer/vendor/bin:$PATH"`

	如
	```sh
	echo 'PATH="~/.config/composer/vendor/bin:$PATH"' >> ~/.bashrc
	source ~/.bashrc
	```

### 问题2:执行时提示git配置文件不存在  

```sh
fatal: unable to read config file '/root/.gitconfig': No such file or directory
```
#### 处理方式

配置一下git全局配置
```
# 姓名
git config --global user.name "xxx"
# 邮箱
git config --global user.email "xxx"
# 提交代码时将换行符转换成LF,签出时不转换
git config --global core.autocrlf input 
# 忽视文件的权限修改
git config --global core.filemode false
# 查看你的git的全局配置
git config --global --list
```

### 问题3:引入HTTP客户端时出错  

使用composer引入`guzzle`时报错

```sh
$ composer require guzzlehttp/guzzle
Using version ^7.0 for guzzlehttp/guzzle
./composer.json has been updated
Loading composer repositories with package information
Updating dependencies (including require-dev)
Your requirements could not be resolved to an installable set of packages.

  Problem 1
    - guzzlehttp/guzzle 7.0.0 requires guzzlehttp/psr7 ^1.6.1 -> satisfiable by guzzlehttp/psr7[1.6.1].
    - guzzlehttp/guzzle 7.0.1 requires guzzlehttp/psr7 ^1.6.1 -> satisfiable by guzzlehttp/psr7[1.6.1].
    - guzzlehttp/psr7 1.6.1 requires ralouphie/getallheaders ^2.0.5 || ^3.0.0 -> no matching package found.
    - Installation request for guzzlehttp/guzzle ^7.0 -> satisfiable by guzzlehttp/guzzle[7.0.0, 7.0.1].

Potential causes:
 - A typo in the package name
 - The package is not available in a stable-enough version according to your minimum-stability setting
   see <https://getcomposer.org/doc/04-schema.md#minimum-stability> for more details.
 - It's a private package and you forgot to add a custom repository to find it

Read <https://getcomposer.org/doc/articles/troubleshooting.md> for further common problems.

Installation failed, reverting ./composer.json to its original content.
```

错误信息中提示` ralouphie/getallheaders ^2.0.5`这个包找不到。  

单独加载这个包也失败了。  

行吧,告别华为镜像站吧。换阿里云的镜像再来一次就成功了
```sh
composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/
```