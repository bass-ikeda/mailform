<!DOCTYPE html>
<html lang="ja">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Content-Script-Type"  content="text/javascript">
    <meta http-equiv="Content-Style-Type" content="text/css">
    <meta name="description" content="show parameters sent by web forms.">
    <meta name="keywords" content="debug, form, parameter">
    <title>Parameters sent by web forms.</title>
</head>
<body>
<h1>Parameters sent by web forms.</h1>
<a href="javascript:history.back()">[back]</a>
<hr />
<h2>Cookie</h2>
<pre><?php var_dump($_COOKIE); ?></pre>

<h2>GET</h2>
<pre><?php var_dump($_GET); ?></pre>

<h2>POST</h2>
<pre><?php var_dump($_POST); ?></pre>

<hr />
<a href="javascript:history.back()">[back]</a>
</body>
</html>
