# prototype-cns11643-to-cin-php


## 操作步驟

請依照下面順序操作。

### 下載資源檔

執行下面指令，下載資源檔。

``` sh
$ make asset
```

或是執行

``` sh
$ composer cin-asset
```

或是執行


``` sh
$ bin/asset.sh
```

會下載[檔案](http://www.cns11643.gov.tw/AIDB/Open_Data.zip)

* asset/Open_Data.zip

然後解開

* asset/Open_Data

主要會產生

* asset/data/CNS_phonetic.txt
* asset/data/CNS2UNICODE_Unicode_2.txt
* asset/data/CNS2UNICODE_Unicode_15.txt
* asset/data/CNS2UNICODE_Unicode_BMP.txt

註：原本就有存在下面這個檔

* data/CNS_phonetic.txt

### 轉檔

執行下面指令，會執行轉檔的動作。

``` sh
$ make cin
```

或是執行

``` sh
$ composer cin
```

或是執行

``` sh
$ bin/cin.php
```

執行完畢後，會產生幾個檔案

* var/CnsPhonetic.cin (cin檔)
* var/CnsPhonetic.csv (對照cin檔，除錯用，有多餘的相關資訊)
* var/InvalidPhonetic.csv (非合法注音列表)
* var/CollisionList.csv (重複的「phonetic - unicode」)


### 觀看「CnsPhonetic.cin」


執行下面指令，觀看「CnsPhonetic.cin」這個檔的內容

``` sh
$ less var/CnsPhonetic.cin
```

也可以執行下面指令，計算「CnsPhonetic.cin」這個檔的行數。

``` sh
$ wc -l var/CnsPhonetic.cin
```


## 相關專案

* [https://github.com/samwhelp/CinConvert](https://github.com/samwhelp/CinConvert)
* [https://github.com/samwhelp/prototype-cns11643-to-cin-nodejs](https://github.com/samwhelp/prototype-cns11643-to-cin-nodejs)
* [https://github.com/samwhelp/prototype-cns11643-to-cin-gjs](https://github.com/samwhelp/prototype-cns11643-to-cin-gjs)
* [https://github.com/samwhelp/prototype-cns11643-to-cin](https://github.com/samwhelp/prototype-cns11643-to-cin)


## 相關討論

* [https://www.ubuntu-tw.org/modules/newbb/viewtopic.php?post_id=354760#forumpost354760](https://www.ubuntu-tw.org/modules/newbb/viewtopic.php?post_id=354760#forumpost354760)
