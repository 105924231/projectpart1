<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="A webpage introducing the group members of S.A Code!">
    <meta name="keywords" content="name, student ID, contribution, about">
    <meta name="author" content="Sophie Kroezen & Akhila Sripriyadarshini Gollamudi">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <title>About Our Group</title>
</head>
<body>
    <?php include 'header.inc'?>
    <br><br>
    <h1>About Us</h1>
    
    <p id="aboutus">Our pride and joy at S.A Coders is delivering simple but effective solutions to our clients, while also having a positive community and environmental impact. Our team work very closely with one another and our desired clientele to ensure that everything is up to an 'above and beyond' standard, and we don't settle for less.</p>
    
   <br>
   <br>

    <section>
        <div class="akhila-header">
            <h2>Meet Akhila</h2>
            <p class="student-id">105931972</p>
        </div>
        <p>Akhila is a first-year student at Swinburne University of Technology. She has begun her studies in Semester 1 of 2025, and will achieve her Bachelor of Computer Science in 2027.</p>
    
        <table class="akhila-table">
            <caption>Interests</caption>
            <thead>
                <tr>
                 <th>
                    Top 5
                </th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td>
                        <div class="akhila-interests">
                            <ol>
                                <li>Animals</li>
                                <li>Swimming</li>
                                <li>Programming</li>
                                <li>Watching movies</li>
                                <li>Video Games</li>
                            </ol>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Ask me about my pet at home!</td>
                </tr>
            </tbody>
        </table>

    <!--"deadpoets.jpg" is sourced from https://www.acmi.net.au/whats-on/focus-peter-weir/dead-poets-society/
    "indianfood.jpg" is sourced from https://www.contiki.com/six-two/article/indian-food/
    "switzerland.jpeg" is sourced from https://www.travelandleisureasia.com/in/destinations/europe/beautiful-places-to-visit-in-switzerland/-->
        
        <h3>Akhila's Favourite...</h3>
        <div class="akhila-favs-container">
            <div class="akhila-favs">
                <div class="akhila-movies">
                    <ol>
                        <em>Movies</em>
                        <li>Dead Poets Society (Peter Weir, 1989)</li>
                        <li>Star Wars (George Lucas)</li>
                        <li>Before Sunrise (Richard Linklater, 1995)</li>
                    </ol>
                    <img src="images/deadpoets.jpg" alt="Dead Poets Society"> 
                </div>
        
                <div class="akhila-food">
                    <ol>
                        <em>Cuisines</em>
                        <li>Indian</li>
                        <li>Thai</li>
                        <li>Italian</li>
                    </ol>
                    <img src="images/indianfood.jpg" alt="Indian Food">
                </div>
        
                <div class="akhila-travel">
                    <ol>
                        <em>Travel Destinations</em>
                        <li>Switzerland</li>
                        <li>Norway</li>
                        <li>Amsterdam</li>
                    </ol>
                    <img src="images/switzerland.jpeg" alt="Switzerland">
                </div>
            </div>
        </div>
    </section>

    <br>
    <br>
    <br>

    <section>
        <div class="sophie-header">
            <h2>Meet Sophie</h2>
            <p class="student-id">105924231</p>
        </div>

        <p>Sophie is a first-year student at Swinburne University of Technology. She has begun her studies in Semester 1, 2025 and will achieve her Bachelor of Games and Interactivity/Bachelor of Computer Science in 2028.</p>
        <table class="sophie-table">
            <caption>Interests</caption>
            <thead>
                <tr>
                    <th>
                        Top 5
                    </th>
                </tr>
            </thead>
    
            <tbody>
                <tr>
                    <td>
                        <ol>
                            <li>Video Games</li>
                            <li>Dogs</li>
                            <li>Baking</li>
                            <li>Netball</li>
                            <li>Programming</li>
                        </ol>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">Ask me about my dog, Charli!</td>
                </tr>
            </tbody>
        </table>

    <!--"up.jpeg" is sourced from https://www.disney.com.au/
        "lifeisstrange.jpeg" is sourced from https://kotaku.com/life-is-strange-sale-xbox-remaster-true-colors-new-game-1851650596
        "hedgehog.jpg" is sourced from https://www.taste.com.au/recipes/hedgehog-slice-2/1d9a30b7-98eb-44fd-a100-655644baeaee-->

        <h3>Sophie's Favourite...</h3>
        <div class="sophie-favs-container">
            <div class="sophie-favs">
                <div class="sophie-movies">
                    <ol>
                        <em>Movies</em>
                        <li>Up (Pete Docter, 2009)</li>
                        <li>Parasite (Bong Joon Ho, 2019)</li>
                        <li>Incantation (Kevin Ko, 2022)</li>
                    </ol>
                    <img src="images/up.jpeg" alt="Up">
                </div>

                <div class="sophie-games">
                    <ol>
                        <em>Video Games</em>
                        <li>Life is Strange (Dontnod Entertainment, 2015)</li>
                        <li>Overcooked (Ghost Town Games, 2016)</li>
                        <li>Until Dawn (Supermassive Games, 2015)</li>
                    </ol>
                    <img src="images/lifeisstrange.jpeg" alt="Life is Strange">
                </div>
                    
                <div class="sophie-baking">
                    <ol>
                        <em>Baked Goods</em>
                        <li>Hedgehog Slice</li>
                        <li>Cheesecake</li>
                        <li>Cinnamon Scrolls</li>
                    </ol>
                    <img src="images/hedgehog.jpg" alt="Hedgehog Slice">
                </div>
            </div>
        </div>
    </section>

    <!--Key group information-->
    <section>
        <h2>Learn About Our Group</h2>
        <ul>
            <li>Where we work:
            <ul>
                <li>Friday 14:30 - 16:30</li>
                <li>ATC325</li>
            </ul>
            </li>
            <li>Who we are:
            <ul>
                <li>Sophie (105924231)</li>
                <li>Akhila (105931972)</li>
            </ul>
            </li>
            <li>Who we work with:
            <ul>
                <li>Group name: S.A Code</li>
                <li>Tutor: Razeen</li>
            </ul>
            </li>
            <img src="images/group-photo.jpg" alt="Photo of the group" id="group-photo">
        </ul>
    
        <!--What each group member worked on throughout the project-->
        <h2>Our Contributions</h2>
        <dl>
            <dt><strong>Akhila</strong></dt>
            <dd>Home Page <em>(HTML &amp; CSS)</em></dd>
            <dd>Job Application Page <em>(HTML)</em></dd>
            <dd>Job Descriptions Page <em>(CSS)</em></dd>
            <dd>Expressions of Interest Table <em>(SQL)</em></dd>
            <dd>Validated Records <em>(PHP)</em></dd>
            <dd>Jobs Table <em>(SQL)</em></dd>
            <dt><strong>Sophie</strong></dt>
            <dd>About Page <em>(HTML &amp; CSS)</em></dd>
            <dd>Job Descriptions Page <em>(HTML)</em></dd>
            <dd>Job Application Page <em>(CSS)</em></dd>
            <dd>Modularise Common Elements <em>(PHP)</em></dd>
            <dd>Settings File <em>(PHP)</em></dd>
            <dd>HR Manager Queries <em>(PHP)</em></dd>
            <dd>Updating Contributions <em>(PHP)</em></dd>
            <dd>Enhancements <em>(PHP &amp; SQL)</em></dd>
        </dl>
    </section>

    <br>
    <br>
    <?php include 'footer.inc'; ?>
</body>
</html>