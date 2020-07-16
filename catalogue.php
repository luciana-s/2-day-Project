<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue</title>
    <link rel="stylesheet" href="styles/catalogue/catalogue.css">
</head>

<body>
    <nav id="order">
    <button>d</button>
    </nav>
    <section id="movies">
        <article id="mock">
            <img src="" alt="">
            <div class="column">
                <div class="id_and_title">
                    <h2 class="id"></h2>
                    <h2 class="title"></h2>
                </div>
                <p class="sinopsis"></p>
            </div>
            <div class="links">
                <a href="" class="more">...See more</a>
                <a href="" class="modify">Modify</a>
            </div>
        </article>
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script>
        //getting the array
        $(function() {
            $.ajax({
                url: 'datamovies.php',
                type: 'post',
                success: function(res) {
                    createArticles(res);
                }
            });
        });

        function createArticles(movies) {
            //cloning and making new movie displays
            movies = jQuery.parseJSON(movies);
            const section = document.querySelector('#movies');
            const model = document.querySelector('#mock');
            console.log(movies);
            movies.forEach(movie => {
                //- Duplicate a mockup <article> tag to the <section>
                const cloneHTML = model.cloneNode(true);
                section.append(cloneHTML)
                //- Adding the cat_id as a class for ordering later
                cloneHTML.classList.add(movie.cat_id);
                //- title
                cloneHTML.querySelector('.title').textContent = movie.title;
                //Movie id
                cloneHTML.querySelector('.id').textContent = '#' + movie.movie_id + ' ';
                //Sinopsis
                cloneHTML.querySelector('.sinopsis').textContent = movie.sinopsis;
                //- modify the <a> to the GET movie id
                cloneHTML.querySelector('.more').href = 'http://localhost/Project/2-day-Project/catalogue.php?id=' + movie.movie_id;
                //- modify the <a> "read more" link (<a>) pointing to the GET movie id
                cloneHTML.querySelector('.modify').href = 'http://localhost/Project/2-day-Project/catalogue.php?id=' + movie.movie_id;
                //img src
                cloneHTML.querySelector('img').src = 'imgs/' + movie.poster;
                // taking out the mock id
                cloneHTML.id = "";
            });
            model.remove();
        }
    </script>
</body>

</html>