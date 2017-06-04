
<form action="?page=add_note" method="POST" enctype="multipart/form-data" name="add_book_form">

    <label for="comment">Comment:</label><br/>
    <textarea name="comment" id="comment"></textarea><br/><br/>

    <input type="submit" value="Lisa" name="add_note"/>
</form>

<div>
<?php
    $sql = "SELECT * FROM tvari_eksam_notes WHERE user_id = ".mysqli_real_escape_string($connection, htmlspecialchars($_SESSION['user_id']));
    $result = mysqli_query($connection, $sql);

    while ($row = mysqli_fetch_assoc($result)){
        echo "<div style='clear: both'>".$row['note']."<br /></div>";
    }
?>
</div>