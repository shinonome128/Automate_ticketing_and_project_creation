<?php

class Ticket {

    private $_argv;
    private $_summary;
    private $_apiKey;
    private $_issueKey;

    public function __construct($argv)
    {
        $this->_argv = $argv;
        $this->checkArgs();
        $this->getApiKey();
        /* $this->createProject(); */
        $this->_issueKey = '407ONEMP-71';
        /* $this->createFolder(); */
        /* $this->createBranch(); */
        $this->createSvn();
        /* $this->createMemo(); */
        /* $this->updateTicket(); */
    }

    /* Check args */
    public function checkArgs()
    {
        if (count($this->_argv) < 2) {
            exit('Invalid arg: php st.php [new ticket title | current project folder name]' . "\n" . '');
        }
        $this->_summary = $this->_argv[1];
        return;
    }

    /* Get api key */
    public function getApiKey()
    {
        $settings = parse_ini_file('settings.ini');
        $this->_apiKey =  $settings['apiKey'];
        return;
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
        $this->_issueKey = json_decode($response, true)['issueKey'];
        return;
    }

    /* Create a project folder */
    public function createFolder()
    {
        $directory = '/Users/mototsugu.kuroda/Documents/'.$this->_issueKey.'-'.$this->_summary;
        mkdir($directory, 0777);
        symlink('/Users/mototsugu.kuroda/Documents/knowledge/ACCOUNTS.md', $directory.'./ACCOUNTS.md');
        symlink('/Users/mototsugu.kuroda/Documents/Onet_make_dev_0.2.1/sources/gotanda', $directory.'/gotanda');
        symlink('/Users/mototsugu.kuroda/Documents/Onet_make_dev_0.2.1/sources/gotanda-tool', $directory.'/gotanda-tool');
        symlink('/Users/mototsugu.kuroda/Documents/Onet_make_dev_0.2.1/sources/superior', $directory.'/superior');
        symlink('/Users/mototsugu.kuroda/Documents/Onet_make_dev_0.2.1/sources/onet', $directory.'/onet');
        symlink('/Users/mototsugu.kuroda/Documents/Onet_make_dev_0.2.1/vm-manager', $directory.'/vm-manager');
        symlink('/Users/mototsugu.kuroda/Documents/Onet_make_dev_0.2.1/0.3.0_DB', $directory.'/DB');
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

    /* Create SVN */
    public function createSvn()
    {
    }

    /* Create MEMO.md */
    public function createMemo()
    {
    }

    /* Update ticket document */
    public function updateTicket()
    {
    }
}

/* Test */
$argv[1] = 'fuga';

/* Done */
$a = new Ticket($argv);
