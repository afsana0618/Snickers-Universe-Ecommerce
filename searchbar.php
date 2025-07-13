<html>
<head>
    <title>Search for Snickers Products</title>
</head>
<body>
    <h1>Snickers Catalog Search</h1>

    <form action="results.php" method="post">
        Choose Search Type:<br />
        <select name="searchtype">
            <option value="name">Product Name</option>
            <option value="description">Description</option>
        </select>
        <br /><br />
        Enter Search Term:<br />
        <input name="searchterm" type="text" size="40" required>
        <br /><br />
        <input type="submit" name="submit" value="Search">
    </form>
</body>
</html>

