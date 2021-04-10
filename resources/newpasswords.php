<?php
echo password_hash('MPN97JUtRT', PASSWORD_DEFAULT); 
echo "<br/>";
echo password_hash('V4ZuiY37A7Pd', PASSWORD_DEFAULT);
?>

<!---
INSERT INTO `employee-login` (`id`, `email`, `FirstName`, `LastName`, `password`, `agencyID`) VALUES (NULL, 'Daniel.Bouton@meridianhs.org', 'Daniel', 'Bouton', '$2y$10$sjhKb.WudTPTpg1EPwgHyOBRSSscdDzy6dhFehYr7z2lJSTqg8goC', '422');
INSERT INTO `employee-login` (`id`, `email`, `FirstName`, `LastName`, `password`, `agencyID`) VALUES (NULL, 'Andrea_Mathews@usc.salvationarmy.org', 'Adrea', 'Mathews', '$2y$10$rXY62LanlnxwFtYeXEqwWenW6EZ74EDugg8arOiCuHIARsi5ePbcG', '826');

-->