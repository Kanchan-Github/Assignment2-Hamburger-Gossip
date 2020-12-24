
function listAll(){
//request list of all  from api
var xhr = new XMLHttpRequest ();
Xhr.setRequestHeader('Content-Type', 'application/json');
//set callback
Xhr.onload = showResults;
Xhr.send();
}
// 
Function showResults(ev) {
alert(this.responseText)
response = JSON.parse(this.responseText);
var str="<table border=0 cellspacing=19 cellpadding=0><tr>";
str+="<th>Person name</th><th>Comment</th><th>Post Date</th><th>Likes</th></tr>";
for(i = 0;i< response.length;i++){
str += "<tr>";
str += "<td><span>"+response[i].name+"</span></td>";
str += "<td><span>"+response[i].text+"</span></td>";
str += "<td><span>"+response[i].post_date+"</span></td>";
str += "<td><span>"+response[i].likes+"</span></td>";
str += "<td><a href='#' onclick=detail ('"+response[i].links+"','"+response[i].id+"')Details</a></td>";
str += "<td><a href='#' onclick=reply ('"+response[i].links+"','"+response[i].id+"')reply</a></td>";
}
str += "</table>";
document.getElementById("mainContainer").innerHTML = str;
}
function sortData(){
var xhr = new XMLHttpRequest();
param=document.getElementById("sortParam").value;
url= "api/list/sort/";
alert(url);
xhr.open('POST', url, true);
xhr.setRequestHeader('Content-Type','application/json');
//set up callback
xhr.onload = showResult;
json = '{"parameter": "'+param+'"}';

xhr.send(json);
}

function detail(links,id){
var xhr = new XMLHttpRequest();
xhr.open('GET', links, true);
xhr.setRequestHeader('Content-Type','application/json');
xhr.onload = showResults;
xhr.send();
}
// show details in table
function showDetail(ev){
response = JSON.parse(this.responseText);
var str="<table border=0 cellspacing=19 cellpadding=0><tr>";
str+="<th>Person name</th><th>Comment</th><th>Post Date</th><th>Likes</th></tr>"
for(i = 0;i< response.length;i++){
str += "<tr>";
str += "td"<span>"+response[i].name+"</span></td>";
str += "td"<span>"+response[i].text+"</span></td>";
str += "td"<span>"+response[i].post_date+"</span></td>";
str += "td"<span>"+response[i].likes+"</span></td>";
str += "<td><a href='#' onclick=detail('"+response[i].links+"','"+response[i].id+"')>Details</a></td>";
str += "</tr>";
str += "<tr> <td></td><td colspan=4><div id='"+response[i].id+"' > </div><td><tr>";
}
str += "<table>";
alert(response[0].reply_to)
document.getElementById(response[0].reply_to+"").innerHTML = str;
}





