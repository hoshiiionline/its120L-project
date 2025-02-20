<?php
include "../includes/header.php";
if (isset($_GET["start-date"], $_GET["end-date"])){
    $startDate = $_GET["start-date"];
    $endDate = $_GET["end-date"];

    ob_start();
    include "../api/roomAvailability.php";
    $jsonOutput = ob_get_clean();

    $availableRooms = json_decode($jsonOutput, true) ?? [];
}
?>

<table>
  <tr>
    <th>Room</th>
    <th>Type</th>
    <th>Book</th>
  </tr>
  <?php foreach ($availableRooms as $room) : ?>
      <tr>
          <td><?php echo htmlspecialchars($room['roomType']); ?></td>
          <td><?php echo htmlspecialchars($room['roomPackage']); ?></td>
      </tr>
  <?php endforeach; ?>
</table>

<?php
include "../includes/footer.php"
?>
