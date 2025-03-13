import os

path=os.getcwd()
repos=['algorithms','hackmetrix','jc-password-manager','laboratorio-lv','metodologia-front','metodologia-back']

for repo in repos:
    print(repo)
    #go to repo
    os.chdir(repo)
    #pull repo
    print(os.system('git pull'))
    #go back to father directory
    os.chdir('..')
