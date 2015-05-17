# Standard project for CodeIgniter

## - For development
* Install Git
    * Windows
        * Read install Git for Windows at [this tutorial](http://tech.pro/tutorial/1840/setting-up-git-and-github-from-the-windows-command-prompt)
    * Ubuntu
        * ```sudo apt-get update```
        * ```sudo apt-get install git```
    * First time setup Git (for all)
        * ```git config --global user.name "Your Name"```
        * ```git config --global user.email "youremail@domain.com"```
        * ```git config --global core.editor vi```
        * ```git config --global color.status auto```
        * ```git config --global color.branch auto```
        * ```git config --global color.interactive auto```
        * ```git config --global color.diff auto```
        * [Generating SSH keys](https://help.github.com/articles/generating-ssh-keys/)
* Install Compass
    * Windows
        * Download and install [Ruby](http://rubyinstaller.org/downloads/)
        * Run __Start command prompt with Ruby__ and install __compass__ via command: ```gem install compass```
    * Ubuntu
        * ```sudo apt-get install ruby``` or ```sudo apt-get install ruby-dev```
        * ```sudo gem install compass```
* Install NodeJS
    * Windows
        * Download and install [NodeJS](https://nodejs.org/download/)
    * Ubuntu
        * ```sudo apt-get install python-software-properties```
        * ```sudo apt-add-repository ppa:chris-lea/node.js```
        * ```sudo apt-get update```
        * ```sudo apt-get install nodejs```
        * Check __NPM__ with ```npm -v```. If __NPM__ are not exists, please run command:
            * ```sudo apt-get install npm```
* Clone this project
* Change directory to project folder
* Change two files:
    * ```cp ./application/config/database.default.php ./application/config/database.php```
    * ```cp .htaccess.default .htaccess```
* Run ```npm install``` to install node modules (run this command under root permission in Ubuntu)
* Run ```npm run dev``` and happy coding :grin:
