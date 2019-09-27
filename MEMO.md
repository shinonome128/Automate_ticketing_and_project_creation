# 目的

タスクが発生したら５秒後にはコードが書けるようにする
チケッティング、プロジェクトフォルダ作成とか一発でできるようにする

# 参照

[github]
(https://github.com/shinonome128/Automate_ticketing_and_project_creation)

# やること

自動化する項目を決める
何をインプットにするか決める
実装

# 自動化する項目を決める

バックログチケット登録
ローカルにプロジェクトフォルダ作成
ブランチ作成
SVN 登録
MEMO.md 作成
チケットドキュメント作成・登録

# 何をインプットにするか決める

チケットタイトルだけ決める
こんな感じ

    cd ~/Documents/
    php st.php 'ローカル開発環境設計_不具合修正'

自動的にローカルでディレクトリフォルダが掘られる

    ~/Documents/XXXXX(チケット番号)_タイトル
    ├── 各ソースへのシンボリックリンク
    └── MEMO.md

MEMO.md を開き、目的とやることとかかる時間を記載
それ以外は自動生成
最後に書きコマンドでバックログにアップロード

    cd ~/Documents/
    php st.php 'XXXXX(チケット番号)_タイトル'

# レポジトリ作成

git で管理する
GUI からレポジトリ作成

    echo "# Automate_ticketing_and_project_creation" >> README.md
    git init
    git add README.md
    git config --local user.email "shinonome128@gmail.com"
    git config --local user.name "shinonome128"
    git commit -m "first commit"
    git remote add origin https://github.com/shinonome128/Automate_ticketing_and_project_creation.git
    git push -u origin master

# プロジェクトフォルダ作成

    ln -s ../knowledge/ACCOUNTS.md ACCOUNTS.md
    ln -s /Users/mototsugu.kuroda/Documents/Onet_make_dev_0.2.1/vm-manager vm-manager

# 実装

phpunit が使えるようになるため、メソッド単位で書いてゆく
メソッドを使うのでオブジェクト指向で書いてゆく

    touch st.php

オブジェクト指向のメリット
変数の名字みたいなもの、同じ太郎でも、名字があると判別がしやすい
phpunit でテストできるようになる

オブジェクト指向の書き方のコツ
インスタンス作成時に必要な変数をコンストラクタにわたす
コンストラクタの中で変数と、処理を記載する
必要な処理はメソッドの中で書いてゆく

オブジェクト指向時の変数の使い分け
クラス内で共有したかったらプライベート
メソッド内で完結する場合はメソッド内の変数

そろそろ Git 登録したいので、API 変数を環境変数化してから実施
done

    touch apiKey.ini
    mv apiKey.ini settings.ini

.gitignore にsetting.ini を登録、 setting.ini.sample を Git に上げる

    echo settings.ini> .gitignore
    cp settings.ini settings.ini.sample

ファイル名とクラス名を揃える

    mv st.php Ticket.php

チケット名、リポジトリ名を変更する

# 積み残し

ソースとプロジェクトフォルダ部分を外部変数にする
Memo.md の自動更新

以上
