<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue</title>
</head>

<body>
    <nav id="order">

    </nav>
    <section id="movies">
        <article id="mock">
            <img src="" alt="">
            <h2><span></span></h2>
            <p></p>
            <a href="">...See more</a>
        </article>
    </section>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script>
        //getting the array
        $(function() {
            $ajax({
                url: 'datamovies.php',
                type: 'post',
                success: createArticles
            })

        })

        function createArticles(movies) {
            //cloning and making new movie displays
            const section = document.querySelector('#movies');
            const model = document.querySelector('#mock');
            movies.forEach(movie => {
                //- Duplicate a mockup <article> tag to the <section>
                const cloneHTML = model.cloneNode(true);
                section.append(cloneHTML)
                //- Adding the cat_id as a class for ordering later
                cloneHTML.classList.add(movie.cat_id);
                //- title
                cloneHTML.querySelector('h2').textContent = movie.title;
                //Movie id
                cloneHTML.querySelector('span').textContent = movie.movie_id;
                //Sinopsis
                cloneHTML.querySelector('p').textContent = movie.sinopis;
                //- modify the <a> "read more" link (<a>) pointing to the GET movie id
                cloneHTML.querySelector('a').href = 'http://localhost/Project/2-day-Project/catalogue.php?id=' + movie.movie_id;
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