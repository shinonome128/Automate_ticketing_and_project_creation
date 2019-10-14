<?php

class Ticket {

    private $_argv;
    private $_summary;
    private $_apiKey;
    private $_issueKey;
    private $_directory;

    public function __construct($argv)
    {
        $this->_argv = $argv;
        $this->_summary = $this->checkArgs();
        $this->_apiKey = $this->getApiKey();
        $this->_issueKey = $this->createProject();
        /* $this->_issueKey = '407ONEMP-82'; */
        $this->_directory = '/Users/mototsugu.kuroda/Documents/'.$this->_issueKey.'-'.$this->_summary;
        $this->createFolder();
        $this->createBranch();
        $this->createMemo();
        $this->createSvn();
        /* $this->updateTicket(); */
    }

    /* Check args */
    public function checkArgs()
    {
        if (count($this->_argv) < 2) {
            exit('Invalid arg: php st.php [new ticket title | current project folder name]' . "\n" . '');
        }
        return $this->_argv[1];
    }

    /* Get api key */
    public function getApiKey()
    {
        $settings = parse_ini_file('settings.ini');
        return $settings['apiKey'];
    }

    /* Create backlog ticket */
    public function createProject()
    {
        $description = 'detail';
        $spaceId = 'flt';
        $params = array(
            'projectId' => '1073927400',
            'issueTypeId' => '1074631194',
            'priorityId' => '3',
            'summary' => $this->_summary,
            'description' => $description,
        );
        $url = 'https://' .$spaceId .'.backlog.jp/api/v2/issues?apiKey='.$this->_apiKey.'&'. http_build_query($params, '','&');
        $headers = array('Content-Type:application/x-www-form-urlencoded');
        $context = array(
            'http' => array(
                'method' => 'POST',
                'header' => $headers,
                'ignore_errors' => true,
            )
        );
        $response = file_get_contents($url, false, stream_context_create($context));
        return json_decode($response, true)['issueKey'];
    }

    /* Create a project folder */
    public function createFolder()
    {
        mkdir($this->_directory, 0777);
        symlink('/Users/mototsugu.kuroda/Documents/knowledge/ACCOUNTS.md', $this->_directory.'/ACCOUNTS.md');
        symlink('/Users/mototsugu.kuroda/Documents/Onet_make_dev_0.2.1/sources/gotanda', $this->_directory.'/gotanda');
        symlink('/Users/mototsugu.kuroda/Documents/Onet_make_dev_0.2.1/sources/gotanda-tool', $this->_directory.'/gotanda-tool');
        symlink('/Users/mototsugu.kuroda/Documents/Onet_make_dev_0.2.1/sources/superior', $this->_directory.'/superior');
        symlink('/Users/mototsugu.kuroda/Documents/Onet_make_dev_0.2.1/sources/onet', $this->_directory.'/onet');
        symlink('/Users/mototsugu.kuroda/Documents/Onet_make_dev_0.2.1/vm-manager', $this->_directory.'/vm-manager');
        symlink('/Users/mototsugu.kuroda/Documents/Onet_make_dev_0.2.1/0.3.0_DB', $this->_directory.'/DB');
    }

    /* Create Branch */
    public function createBranch()
    {
        $path = '/Users/mototsugu.kuroda/Documents/Onet_make_dev_0.2.1/sources/gotanda';
        chdir($path);
        exec('git checkout master');
        /* exec('git pull'); */
        exec('git checkout -b feature/'.$this->_issueKey.'/'.$this->_summary);

        $path = '/Users/mototsugu.kuroda/Documents/Onet_make_dev_0.2.1/sources/gotanda-tool';
        chdir($path);
        exec('git checkout master');
        /* exec('git pull'); */
        exec('git checkout -b feature/'.$this->_issueKey.'/'.$this->_summary);

        $path = '/Users/mototsugu.kuroda/Documents/Onet_make_dev_0.2.1/sources/superior';
        chdir($path);
        exec('git checkout master');
        /* exec('git pull'); */
        exec('git checkout -b feature/'.$this->_issueKey.'/'.$this->_summary);

        $path = '/Users/mototsugu.kuroda/Documents/Onet_make_dev_0.2.1/sources/onet';
        chdir($path);
        exec('git checkout master');
        /* exec('git pull'); */
        exec('git checkout -b feature/'.$this->_issueKey.'/'.$this->_summary);

        $path = '/Users/mototsugu.kuroda/Documents/Onet_make_dev_0.2.1/vm-manager';
        chdir($path);
        exec('git checkout master');
        /* exec('git pull'); */
        exec('git checkout -b feature/'.$this->_issueKey.'/'.$this->_summary);
    }

    /* Create MEMO.md */
    public function createMemo()
    {
        chdir(dirname(__FILE__));
        $str = file_get_contents('MEMO.md.sample');
        $str = str_replace('$this->_summary', $this->_summary, $str);
        $str = str_replace('$this->_issueKey', $this->_issueKey, $str);
        file_put_contents($this->_directory.'/MEMO.md', $str);
    }

    /* Create SVN */
    public function createSvn()
    {
        chdir($this->_directory);
        echo $this->_directory;
        exec('svn mkdir https://flt.backlog.jp/svn/407ONEMP/'.$this->_issueKey.' -m "Add new dir"');
        exec('svn co https://flt.backlog.jp/svn/407ONEMP/'.$this->_issueKey.' ./');
        exec('svn add MEMO.md');
        exec('svn commit -m "Add first commit"');
    }

    /* Update ticket document */
    public function updateTicket()
    {
        // ToDo
    }
}

/* Test */
/* $argv[1] = 'fugahoge'; */

/* Done */
$a = new Ticket($argv);
