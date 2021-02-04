<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row gx-5">
            <div class="col-3">
                <form  method="post"> <!-- action="index.php" -->
                    <label for="months">Mois:</label><br>
                    <select name="months" id="month-select">
                        <option value="">--Sélectionnez un mois--</option>
                        <option value="1">Janvier</option>
                        <option value="2">Février</option>
                        <option value="3">Mars</option>
                        <option value="4">Avril</option>
                        <option value="5">Mai</option>
                        <option value="6">Juin</option>
                        <option value="7">Juillet</option>
                        <option value="8">Aout</option>
                        <option value="9">Septembre</option>
                        <option value="10">Octobre</option>
                        <option value="11">Novembre</option>
                        <option value="12">Décembre</option>
                    </select><br>
                    <label for="years">Année:</label><br>
                    <select name="years" id="year-select">
                        <option value="">--Sélectionnez une année   --</option>
                        <option value="2010">2010</option>
                        <option value="2011">2011</option>
                        <option value="2012">2012</option>
                        <option value="2013">2013</option>
                        <option value="2014">2014</option>
                        <option value="2015">2015</option>
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                    </select><br>
                    <input type="submit" id="confirmForm" value="Valider">
                </form>
            </div>
            <div class="col-8">
                <table class="table table-bordered">                      
                    <tbody>
                            <?php

                                
                                if(isset($_POST["months"])== false|| isset($_POST["years"])== false || $_POST["months"] == null || $_POST["years"] == null)
                                {
                                    // echo "Entrez une date";
                                    ?>
                                    <p>Entrez une date.</p>
                                    <?php
                                }
                                else
                                {
                                    function testFirstWeekYear($year, $month) //Fonction permettant de tester et définir si le premier jour du mois se trouve encore dans la dernière semaine de l'année précédente, ou non
                                    {
                                        $firstWeek = date("W", strtotime("$year-$month-01"));
                                        $secondWeek = date("W", strtotime("$year-$month-08"));
                                        if($firstWeek > $secondWeek)
                                        {
                                            return 0;
                                        }
                                        else
                                        {
                                            return $firstWeek;
                                        }
                                    }

                                    function testDayFirstWeekYear($year, $month, $day) //Fonction permettant de tester et définir si le jour donné se trouve encore dans la dernière semaine de l'année précédente, ou non
                                    {
                                        $firstWeek = date("W", strtotime("$year-$month-$day"));
                                        $secondWeek = date("W", strtotime("$year-$month-$day +7 day"));
                                        if($firstWeek > $secondWeek)
                                        {
                                            return 0;
                                        }
                                        else
                                        {
                                            return $firstWeek;
                                        }
                                    }

                                    setlocale(LC_TIME, "fr_FR.utf8", "fra"); //définit la localisation pour faciliter le traitement des dates
                                    $month = $_POST["months"]; //Mois sélectionné
                                    $year = $_POST["years"]; //Année sélectionnée
                                    $nbDayWeek = 7; //Nombre de jours dans une semaine  
                                    $strMonth = strval($month); //Convertit la valeur int du mois en String
                                    $strYear = strval($year);   //Convertit la valeur int de l'année en String
                                    $nbDayMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year); //Compte le nombre de jours dans le mois
                                    $firstDayMonth = date("j", strtotime("$year-$month-01")); //Récupère le premier jour du mois
                                    $nbFirstWeekMonth = testFirstWeekYear($year, $month); //Récupère le numéro de la première semaine du mois dans l'année grâce à une fonction
                                    $nbLastWeekMonth = date("W", strtotime("$year-$month-$nbDayMonth")); //Récupère le numéro de la dernière semaine du mois dans l'année
                                                    
                                    ?>
                                    <tr><tdcolspan='7'><?= strftime("%B %G", strtotime("$year-$month-15"))?></td></tr>
                                    
                                    <tr style='background-color:#FEE6AE'>
                                        <th scope='col'>Lundi</th>
                                        <th scope='col'>Mardi</th>
                                        <th scope='col'>Mercredi</th>
                                        <th scope='col'>Jeudi</th>
                                        <th scope='col'>Vendredi</th>
                                        <th scope='col'>Samedi</th>
                                        <th scope='col'>Dimanche</th>
                                    </tr>

                                    <?php
                                    
                                    for($i=$nbFirstWeekMonth;$i<=$nbLastWeekMonth;$i++) //Boucle allant de la première à la dernière semaine du mois
                                    {
                                        ?>
                                        <tr>
                                        <?php
                                        for($j=1;$j<=$nbDayWeek;$j++) //Boucle allant du premier au dernier jour de la semaine (de Lundi à Dimanche)
                                        {
                                            ?>
                                            <td>
                                            
                                            <?php
                                            for($k=1; $k<=$nbDayMonth;$k++) //Boucle allant du premier au dernier jour du mois
                                            {
                                                $timestamp = strtotime($strYear."-".$strMonth."-".strval($k)); //transforme les string entrés en Date  
                                                $week = date("W", $timestamp); //n° de la semaine du jour actuel
                                                $firstWeekDay = testDayFirstWeekYear($year, $month, $k); //Test si la semaine du jour actuel est la première de l'annéé à l'aide d'une fonction
                                                $day = date("N", $timestamp); //n° du jour actuelle dans la semaine

                                                if($k == $firstDayMonth && $day == $j && $week != $i && $i < 1)
                                                {
                                                    echo $k;
                                                    break;
                                                }
                                                elseif($week == $i && $day == $j)
                                                {
                                                    echo $k;
                                                }
                                                elseif($day == $j && $firstWeekDay == $i)
                                                {
                                                    echo $k;
                                                }
                                            }
                                            ?>
                                            </td>
                                            <?php
                                        }
                                        ?>
                                        </tr>
                                        <?php
                                    }
                                }
                            ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script></script>

</body>
</html>