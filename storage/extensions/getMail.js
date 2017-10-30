var a = document.getElementsByClassName('_108_');
var b = document.getElementsByClassName('_3cw_');
var lagAllow = 5;
var time = 1000;
var interval01, interval02, arr, index = 0, rs = '',result = '', rsArr = [],
index = 0, choose, start, end, lastComment, timeToLoadComment = lagAllow, timeToLoadReply = 5;
var removeCharacter = ['email:', ':', ','];
var regex = /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/;
start = new Date();
// do
// {
//     choose = prompt("Press 1 to export email with index\nPress 2 to export email without index");
// } while(choose < 1 || choose > 2);

interval01 = setInterval(function(){loadMoreComment()}, time);

function getLastComment()
{
    var temp = document.getElementsByClassName('_14ye');
    return temp[temp.length-1].innerText;
}

function standard(n)
{
    if(n<10)
    {
        return "0" + n;
    }
    return n;
}

function getNow()
{
    var currentdate = new Date(); 
    return "[" + standard(currentdate.getHours()) + ":" + standard(currentdate.getMinutes()) + ":" + standard(currentdate.getSeconds()) +"] ";
}
function addArr(str)
{
    if(rsArr[str] == undefined)
    {
        rsArr[str] = 0;
    }
    else
    {
        rsArr[str]++;
    }
}
function isEmail(email) {
    if(regex.test(email)) {
        return true;
    }
    else {
        return false;
    }
}

function loadMoreComment()
{
    console.log(getNow() + "Loading more comment...");
    if(lastComment == getLastComment())
    {
        console.log(getNow() + "Try to load more comment: " + timeToLoadComment--);
    }
    else {
        if(timeToLoadComment != lagAllow)
        {
            console.log(getNow() + "Try to load more comment: " + timeToLoadComment);
        }
        timeToLoadComment = lagAllow;
    }
    
    if(a.length == 0 || timeToLoadComment == 0)
    {
        console.log(getNow() + "Load more comment done");
        clearInterval(interval01);
        console.log(getNow() + "Loading all reply comment...");

        for(var i=0; i<b.length; i++)
        {
            b[i].click();
        }
        console.log(getNow() + "Load all reply comment done");

        interval02 = setInterval(function(){loadComments()}, 1000);
        return ;

    }
    else{
        lastComment = getLastComment();
        a[0].click();
        window.scrollTo(0,  document.body.scrollHeight);
    }
}


function loadComments(event)
{
    timeToLoadReply--;
    console.log(getNow() + "Processing email in comment...");

    if(b.length == 0)
    {
        clearInterval(interval02);
        var c = document.getElementsByClassName('_14ye');
        var d = document.getElementsByClassName('_52jh _1s79');

        for(var i=0; i<c.length; i++)
        {
            if(c[i].innerText != "")
            {
                rs = c[i].innerText.replace(/\s+/g, ' ').toLowerCase() + ' ';
                for(var item in removeCharacter){
                    rs = rs.replace(removeCharacter[item],'');
                }
                arr = rs.split(" ");
                for(var item in arr)
                {
                    if(isEmail(arr[item]))
                    {
                        addArr(arr[item]);
                    }
                }
            }
        }
        // Load comment complete
        console.log(getNow() + "Process complele");
        end = new Date();
        for (var key in rsArr) {
            index++;
            result += key + "\n";
        }
        console.log(result);
        console.log(getNow() + "Time to process: " + ((end - start)/1000) + "s ");
        console.log(getNow() + "You have " + index + " email(s) in this process");
        console.log(getNow() + "Press 'copy(result)' to copy data in your clipboard");
    }
}