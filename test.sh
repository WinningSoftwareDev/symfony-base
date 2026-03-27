#SIGNED_STATUS=(`git log -1 --pretty=format:%G?`)
#
#echo "$SIGNED_STATUS"
#
#if [ "$SIGNED_STATUS" = "G" ] || [ "$SIGNED_STATUS" = "U" ]; then
#  echo "Commit is GPG-signed ✅"
#else
#  echo "Commit is NOT GPG-signed ❌"
#  exit 1
#fi

echo $(date)