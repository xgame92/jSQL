<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>jSQL test</title>
    </head>
    <body>
		<script src="../../jSQL.js"></script>
		<h1 id="loading">Loading</h1>
		<div id="hidden" style="display:none;">
			<b>Enter your query: </b>
			<textarea id="textarea" style="display:block; width:100%;">SELECT * FROM `zips` WHERE `TERR` = 'FL03' ORDER BY city, zip DESC LIMIT 25</textarea>
			<button onclick="doQuery()">Run Query</button>
			<div id="res"></div>
		</div>
		<script>

			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (xhttp.readyState == 4 && xhttp.status == 200) {
					var data = JSON.parse(xhttp.responseText);
					jSQL.createTable("zips", data);
					document.getElementById('loading').style.display = "none";
					document.getElementById('hidden').style.display = "block";
				}
			};
			xhttp.open("GET", "zips.data.json", true);
			xhttp.send();
			
			function doQuery(){
				var sql = document.getElementById('textarea').value;
				try{
					var query = jSQL.query(sql).execute();
					var results = query.fetchAll();
					document.getElementById('res').innerHTML = makeTable(results);
				}catch(e){
					document.getElementById('res').innerHTML = "<b>"+e+"</b>";
				}
			}
			
			function makeTable(res){
				var html = ["<table><thead><tr>"];
				if('undefined' == typeof res[0]) throw "No table data..";
				for(var name in res[0]){
					if(res[0].hasOwnProperty(name)){
						html.push("<th>"+name+"</th>");
					}
				}
				html.push("</tr></thead><tbody>");
				for(var i=0; i<res.length; i++){
					html.push("<tr>");
					for(var name in res[i]){
						if(res[0].hasOwnProperty(name)){
							html.push("<td>"+res[i][name]+"</td>");
						}
					}
					html.push("</tr>");
				}
				html.push("</tbody></table>");
				return html.join('');
			}
	
		</script>
    </body>
</html>