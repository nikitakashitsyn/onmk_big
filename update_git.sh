#!/usr/bin/bash
cd /home/onmk/onmk

gitlast="`cat latest_git.head`"

gitcurrent=`curl -s https://gitlab.com/api/v4/projects/34370507/repository/branches/master -H "PRIVATE-TOKEN:glpat-RySMJTUzEjK5yKw7Q1xh"|jq -r .commit.id`

if [ "$gitlast" = "$gitcurrent" ]; then
    echo "No need to update"
else
    echo $gitcurrent> latest_git.head
    echo "Update"
    git fetch
    git reset --hard origin/master
fi

