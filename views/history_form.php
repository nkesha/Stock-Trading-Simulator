<table>
    <?php
    $result = CS50::query ("SELECT * FROM history");
    
    if ($result)
    {
        foreach ($result as $row)
        {
            print("<tr>");
            print("<td>" . $row["action"] . "</td>");
            print("<td>" . $row["symbol"] . "</td>");
            print("<td>" . $row["shares"] . "</td>");
            print("<td>" . $row["price"] . "</td>");
            print("<td>" . $row["time"] . "</td>");

        }
    }
    ?>
    
</table>