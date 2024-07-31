<?php
$url = 'https://indico.cern.ch';
$url = $url . '/export/categ/5666.json';
$url = $url . '?from=today';
$url = $url . '&order=start';

$response = json_decode(file_get_contents($url), true);

$meetings = array();
foreach ($response['results'] as $result) {
  $meeting = array();

  // ID
  $meeting['id'] = $result['id'];

  // Title
  $meeting['title'] = $result['title'];

  // Description
  $meeting['description'] = $result['description'];

  // Start time
  $startTimeStr = $result['startDate']['date'] . " " .
                  $result['startDate']['time'];
  $startTime = new DateTime(
    $startTimeStr,
    new DateTimeZone($result['startDate']['tz'])
  );
  $meeting['startTime'] = $startTime->format('Y M d, H:i T');

  // URL
  $meeting['url'] = $result['url'];

  // Room
  if (empty($result['roomFullname'])) {
    $meeting['location'] = $result['location'];
  } else {
    $meeting['location'] = $result['roomFullname'];
  }

  // print_r($result);
  // echo "<br><br><br><br>";
  array_push($meetings, $meeting);
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FCC Software Meetings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
      <?php foreach($meetings as $meeting): ?>
      <div class="row me-1">
        <div class="col mt-3 bg-light rounded">
          <p class="text-muted mb-0">
            <small><?= $meeting['startTime']; ?></small>
          </p>
          <p class="h3">
            <a href="<?= $meeting['url']; ?>"
               class="link-underline link-underline-opacity-0 link-underline-opacity-50-hover"
               title="<?= $meeting['startTime'] . " | " . $meeting['title']; ?>"
               target="_blank"><?= $meeting['title']; ?></a>
          </p>
          <div class="row text-muted mb-2">
            <div class="col">
              <small>
                <svg xmlns="http://www.w3.org/2000/svg"
                     width="16"
                     height="16"
                     fill="currentColor"
                     class="bi bi-geo-alt"
                     viewBox="0 0 16 16">
                  <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10"/>
                  <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                </svg>
                <?= $meeting['location']; ?>
              </small>
            </div>
            <div class="col text-end">
              <small>
                <?php if (!empty($meeting['description'])): ?>
                <a class="link-secondary link-underline link-underline-opacity-0"
                   data-bs-toggle="collapse"
                   href="#event-desc-<?= $meeting['id']; ?>">Show description</a>
                <?php endif ?>
              </small>
            </div>
          </div>
          <div class="collapse mb-3" id="event-desc-<?= $meeting['id']; ?>">
            <div class="card card-body">
              <?= $meeting['description']; ?>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach ?>

      <p class="mt-3">
        The Indico category for all FCC Software and Computing meetings can be found
        <a href="https://indico.cern.ch/category/5666/"
           class="link-underline link-underline-opacity-0 link-underline-opacity-50-hover">here</a>.
      <p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
  </body>
</html>
