<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>
<body>
<form action="/" method="POST">
    <br />
    <br />
    <br />

    @csrf
    <div class="flex space-x-3">
        <div class="col-md-4">
            <input type="datetime-local" name="start_time" id="start_time" class="form-control" />
        </div>

        <div class="col-md-4">
            <input type="datetime-local" name="end_time" id="end_time" class="form-control"  />
        </div>
        <input  type="number" name="distanca" class="form-control"/>
    </div>
    <br />
    <br />
    <button type="submit" class="form-control">Calculate</button>
</form>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>




