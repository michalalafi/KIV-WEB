<?php

	require_once('Controllers/ArticlesController.php'); 


	echo "<div class='container'>";
        echo "<h1> Vypublikované články </h1><br>";
    $articles = ArticlesController::getArticlesByState("Schválen");
        echo "                                                                                 
              <div class='table-responsive'>          
                <table class='table'>
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Název</th>
                        <th>Autoři</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>";

                    // Číslování řádek
                    $index = 0;
                    foreach ($articles as $article) {
                        $index++;
                        echo "<tr>";
                            echo "<td>" . $index . "</td>";
                            echo "<td>" . $article['NAME'] . "</td>";
                            echo "<td>" . $article['AUTHORS'] . "</td>";
                            echo "<form class='form-horizontal' method = 'post' action = 'index.php?page=article_detail'>";
                            echo "<input type='hidden' class='form-control' name = 'id_Article' value = '" . $article['ID'] . "'>";
                            echo "<td><input type='submit' class='form-control btn-primary' name = 'article_detail' value = 'Detail'></td>";
                            echo "</form>";
                        echo "</tr>";
                    }
                    echo "
                    </tbody>
                </table>
            </div>";
    echo "</div>";

