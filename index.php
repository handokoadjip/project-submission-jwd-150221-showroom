<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<title>Showroom Mobil Bekas</title>

	<!-- Library CSS -->
	<link rel="stylesheet" href="public_html/css/library.css">
</head>

<body>
	<?php

	// Prosedur tampilkan_logo_honda()
	// digunakan untuk menampilkan logo dan tulisan Honda
	// apabila merk mobilnya "Honda",
	// dan tulisan merk mobil lainnya tanpa logo.
	// Kompleksitas penggunaan resources: O(1)

	/**
	 * 
	 * desc:
	 * menampilkan logo honda jika string bernilai honda
	 * 
	 * @param array $merkMobil
	 * 
	 * @return string
	 */
	function tampilkan_logo_honda($merkMobil)
	{
		if ($merkMobil === "Honda") {
			echo "<img src='public_html/images/Honda.png' /> $merkMobil";
		} else {
			echo $merkMobil;
		}
	}

	// variabel untuk menyimpan Jumlah Total Penjualan
	$total_penjualan = 0;

	// Fungsi tampilkan_total_penjualan()
	// digunakan untuk mengembalikan jumlah total penjualan
	// Kompleksitas penggunaan resources: O(1)

	function tampilkan_total_penjualan()
	{

		// mengembalikan variabel Jumlah Total Penjualan
		$GLOBALS['total_penjualan'];
	}

	// menyimpan input data penjualan ke file "data.txt"
	if (isset($_POST['simpan'])) {

		// membuka file "data.txt"
		$fp = fopen("resources/data/data.txt", "a");

		// menuliskan data penjualan baru ke dalam file, 
		// bila nilai input-nya terisi semua
		if (isset($_POST['merk']) && trim($_POST['nama']) != "" && trim($_POST['merk']) != "" && trim($_POST['jumlah']) != "")
			fwrite($fp, $_POST['nama'] . "###" . $_POST['merk'] . "###" . $_POST['jumlah'] . "\r\n");

		// menutup pembacaan file
		fclose($fp);
	}
	?>
	<table>
		<tr>
			<td class="td-top">
				<h3>Input Data:</h3>
				<form action="index.php" method="POST">
					<label for="nama">Nama Pembeli: </label><br />
					<input type="text" name="nama" id="nama" size="30"><br />
					<br />
					Merk Mobil Bekas: <br />
					<?php

					// membuat array merk mobil:
					$arrayMerk = ["Toyota", "Honda", "Daihatsu", "Suzuki", "Nissan"];

					// mengurutkan arraymerk mobil berdasarkan abjad:
					sort($arrayMerk);

					?>

					<!-- menampilkan pilihan radio button untuk merk mobil yang sudah diurutkan:  -->
					<?php foreach ($arrayMerk as $merk) : ?>
						<input type="radio" id="<?= $merk; ?>" name="merk" value="<?= $merk; ?>">
						<label for="<?= $merk; ?>"><?= $merk; ?></label><br>
					<?php endforeach; ?>


					<br />
					<label for="jumlah">Jumlah Pembelian: </label><br />
					<input type="text" name="jumlah" id="jumlah" size="5"> unit<br /><br />
					<input type="submit" name="simpan" value="SIMPAN" class="tombol" />
				</form>
			</td>
			<td class="td-space">
				&nbsp;
			</td>
			<td class="td-top td-border">
				<h3>Data Penjualan:</h3>
				<table class="tbl">
					<tr>
						<th>Nama Pembeli</th>
						<th>Merk Mobil Bekas</th>
						<th>Jumlah Unit</th>
					</tr>
					<?php

					// ambil data penjualan dengan membaca file "data.txt"
					$fp = fopen("resources/data/data.txt", "r");

					// jika pembacaan file berhasil
					if ($fp) {

						// membaca file baris demi baris hingga selesai
						while (($baris = fgets($fp, 4096)) !== false) {

							echo "<tr>";

							// memisahkan data di setiap baris berdasarkan karakter "###"
							$data = explode("###", $baris);
							// data[0] = Nama Pembeli
							// data[1] = Merk Mobil Bekas
							// data[2] = Jumlah unit

							// mencetak data di kolom Nama pada tabel
							echo "<td>" . $data[0] . "</td>\r\n";

							// mencetak data di kolom Merk pada tabel
							echo "<td>";

							// menampilkan juga logo Honda bila Merknya "Honda"
							// dengan memanggil Prosedur tampilkan_logo_honda()
							tampilkan_logo_Honda($data[1]);

							echo "</td>\r\n";

							// mencetak data di kolom Jumlah pada tabel
							echo "<td>" . $data[2] . "</td>\r\n";

							echo "</tr>";

							// meng-update (variabel) Jumlah Total Penjualan mobil
							$total_penjualan += (int)$data[2];
						}
						if (!feof($fp)) {
							echo "baca file gagal\n";
						}

						// tutup pembacaan file
						fclose($fp);
					}

					?>
					<tr class="tr-yel">
						<td colspan="2">Jumlah Total Penjualan</td>
						<td>
							<?php

							// menampilkan jumlah total penjualan mobil
							// dengan memanggil Fungsi tampilkan_total_penjualan();
							echo tampilkan_total_penjualan();

							?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>

</html>