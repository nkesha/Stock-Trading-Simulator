<table>
    <?php
    
    foreach ($positions as $position)
    {
        print("</tr>");
        print("<td>" . $position["symbol"] . "</td>");
        print("<td>" . $position ["shares"] . "</td>");
        print("</tr>");
    }
    ?>
</table>
