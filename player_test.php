    <form action="player.php" method="POST">
        
        <label for="player_name">Имя</label>
        <input type="text" name="player_name">
        
        <label for="player_phone">Телефон</label>
        <input type="text" name="player_phone">

        <br>

        <label for="player_phone">Призы</label>
        <input type="text" name="prizes" value="4">

        <label for="player_phone">Попыток осталось</label>
        <input type="text" name="tries" value="1">

        <br>

        <label for="player_phone">Купил билет</label>
        <input type="text" name="ticket" value="1">

        <label for="player_phone">Сделал репост</label>
        <input type="text" name="repost" value="1">

        <br>

        <button type="submit">Go</button>

    </form>
<?php

    require_once('player_test.php');
