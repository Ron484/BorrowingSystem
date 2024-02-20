<!DOCTYPE html>
<html>
<head>
    <title>Books List</title>
    <style>
 body {
            font-family: Arial, sans-serif;
            /* background-color: #f9ffe0; */
            /* padding: 5px; */
            
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h3 {
            color: #7a8303;
            margin-bottom: 13px;
        }
        h5{
            color: #465731;
            margin-bottom: 20px;
        }
        p {
            color: #cfcfc8;
            margin-bottom: 20px;
        }
        .book-details {
            margin-bottom: 45px;
        }
        .book-details strong {
            font-weight: bold;
        }    </style>
</head>
<body>
    <h3>Books List</h3>


    <div class="container">
        @foreach($Books as $book)

        <h3>Title: {{ $book->title }}</h3>
        <div class="book-details">
            <h5>Book Details</h5>
            <p><strong>Author:</strong> {{ $book->author }}</p>
            <p><strong>Publisher:</strong> {{ $book->publisher }}</p>
            <p><strong>Category:</strong> {{ $book->category->name }}</p>
       
        </div>
        <div class="book-details">
            <h5>Book Content</h5>
            <p><strong>Description:</strong> {{ Str::limit(strip_tags($book->description), 50) }}</p>
          
             <p><strong>Pages:</strong> {{ $book->pages }}</p>

        </div>

        @endforeach

    </div>
</body>
</html>
