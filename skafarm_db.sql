-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 22, 2025 at 01:52 PM
-- Server version: 8.0.30
-- PHP Version: 8.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `skafarm_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id_detail` int NOT NULL,
  `id_transaksi` int NOT NULL,
  `kode_produk` varchar(255) NOT NULL,
  `qty` int NOT NULL,
  `harga_satuan` int NOT NULL,
  `harga_total` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id_detail`, `id_transaksi`, `kode_produk`, `qty`, `harga_satuan`, `harga_total`) VALUES
(53, 63, '12', 4, 1000000, 4000000);

-- --------------------------------------------------------

--
-- Table structure for table `gudang`
--

CREATE TABLE `gudang` (
  `kode_gudang` varchar(255) NOT NULL,
  `nama_gudang` varchar(255) NOT NULL,
  `golongan` varchar(255) NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `gudang`
--

INSERT INTO `gudang` (`kode_gudang`, `nama_gudang`, `golongan`, `keterangan`) VALUES
('6', 'Gudang B', 'Buah', 'Tempat penyimpanan buah segar hasil panen seperti semangka, melon, dan pepaya'),
('7', 'Gudang C', 'Pupuk', 'Berisi pupuk organik dan kimia untuk mendukung pertumbuhan tanaman'),
('8', 'Gudang D', 'Alat', 'Menyimpan alat pertanian seperti cangkul, sprayer, selang, dan sensor IoT'),
('GD00A', 'Gudang A', 'Sayur', 'Menyimpan berbagai sayuran segar seperti bayam, sawi, kangkung, dan selada'),
('GD00AB', 'Gudang E', 'Lainnya', 'Gudang serbaguna untuk menyimpan kebutuhan tambahan Smart Farm');

-- --------------------------------------------------------

--
-- Table structure for table `master_blog`
--

CREATE TABLE `master_blog` (
  `id_blog` int NOT NULL,
  `kode_user` int NOT NULL,
  `judul` varchar(255) NOT NULL,
  `artikel` text NOT NULL,
  `img` text NOT NULL,
  `created_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `master_blog`
--

INSERT INTO `master_blog` (`id_blog`, `kode_user`, `judul`, `artikel`, `img`, `created_at`) VALUES
(2, 15, 'Tips Menanam Tomat Hidroponik', 'Bayam, dengan daun hijaunya yang kaya nutrisi, merupakan komponen penting dalam produk smoothie dan keripik sayur yang ditawarkan oleh petani muda. Untuk mencapai kualitas premium yang dibutuhkan pasar camilan sehat, proses budidaya bayam harus dilakukan dengan cermat dan penuh perhatian terhadap detail lingkungan. Bayam segar tumbuh subur di tanah yang gembur dan kaya bahan organik, memastikan akar dapat menyerap nutrisi secara maksimal. Di sinilah peran sensor IoT yang telah dibahas sebelumnya menjadi sangat vital; sensor tersebut tidak hanya memonitor kelembaban tanah, tetapi juga membantu petani menjaga sistem irigasi, memastikan bahwa kebutuhan air bayam terpenuhi secara konsisten tanpa terjadi over-watering yang dapat merusak akar atau membuang-buang air. Keseimbangan air ini penting agar bayam memiliki tekstur yang ideal dan kandungan klorofil yang tinggi, yang langsung memengaruhi rasa dan nilai gizi camilan akhir.\r\n\r\nAspek inovatif dan keberlanjutan dari budidaya bayam semakin menonjol melalui pemanfaatan pupuk cair alami. Petani muda yang visioner kini menerapkan konsep ekonomi sirkular (lingkar) dalam pertanian mereka, di mana limbah dari proses pengolahan camilan justru diubah menjadi sumber daya baru. Sisa-sisa sayuran, kulit buah pisang, atau bahkan bagian singkong yang tidak terpakai dari proses pembuatan keripik dan smoothie, tidak dibuang begitu saja. Sebaliknya, sisa-sisa organik ini diolah melalui proses fermentasi sederhana menjadi pupuk cair alami, kaya akan unsur hara mikro dan makro yang dibutuhkan bayam. Penggunaan pupuk cair alami ini memiliki dampak ganda: pertama, ia mengurangi biaya pembelian pupuk kimia yang mahal; dan kedua, ia memastikan bahwa bayam ditanam secara organik atau semi-organik, memenuhi permintaan pasar premium yang mencari produk clean-label (berlabel bersih) dan bebas residu kimia.\r\n\r\nSiklus tertutup yang diciptakan oleh praktik ini—dari panen, diolah, dan limbahnya kembali menjadi pupuk untuk panen berikutnya—menjadi Unique Selling Proposition (USP) yang sangat kuat bagi brand camilan sehat para petani muda. Mereka tidak hanya menjual produk yang sehat, tetapi juga sebuah narasi utuh tentang pertanian yang bertanggung jawab dan berkelanjutan. Mereka dapat dengan bangga mengklaim bahwa produk mereka, misalnya Keripik Bayam Organik, dihasilkan melalui proses yang hampir tanpa limbah dan didukung oleh pupuk buatan sendiri. Keunggulan narasi ini memungkinkan mereka mematok harga yang lebih baik dibandingkan produk konvensional, sehingga meningkatkan margin keuntungan dan mendukung harga beli yang adil bagi petani produsen.\r\n\r\nKesuksesan dalam budidaya bayam yang mengombinasikan teknologi presisi (IoT) dan kearifan lokal (pupuk alami) ini kemudian direplikasi pada komoditas lain seperti singkong dan pisang. Filosofi yang sama diterapkan: memonitor kondisi tumbuh yang optimal untuk mencapai kualitas bahan baku terbaik, sambil memaksimalkan penggunaan kembali limbah panen dan pengolahan. Dengan demikian, petani muda telah menciptakan model pertanian yang ideal: efisien berkat data IoT, produktif berkat teknik budidaya yang optimal, dan berkelanjutan berkat sistem pupuk alami dari daur ulang limbah.\r\n\r\nModel pertanian holistik ini adalah bukti nyata evolusi agripreneur muda Indonesia. Mereka telah melangkah jauh melampaui sekadar menanam dan memanen. Mereka mengelola tanah gembur dan air irigasi dengan teknologi termutakhir, sekaligus menerapkan ekonomi sirkular dengan pupuk alami. Inilah yang menjadi fondasi kualitas premium produk olahan mereka—menghasilkan keripik singkong dan smoothie bayam-pisang yang tidak hanya lezat dan sehat, tetapi juga dihasilkan dengan hati-hati dan tanggung jawab penuh terhadap lingkungan, menetapkan standar baru untuk masa depan ketahanan pangan nasional.', 'prd_68dc028165334.jpg', '2025-09-01'),
(3, 15, 'Manfaat Pupuk Organik untuk Tanaman', 'Bayam, dengan daun hijaunya yang kaya nutrisi, merupakan komponen penting dalam produk smoothie dan keripik sayur yang ditawarkan oleh petani muda. Untuk mencapai kualitas premium yang dibutuhkan pasar camilan sehat, proses budidaya bayam harus dilakukan dengan cermat dan penuh perhatian terhadap detail lingkungan. Bayam segar tumbuh subur di tanah yang gembur dan kaya bahan organik, memastikan akar dapat menyerap nutrisi secara maksimal. Di sinilah peran sensor IoT yang telah dibahas sebelumnya menjadi sangat vital; sensor tersebut tidak hanya memonitor kelembaban tanah, tetapi juga membantu petani menjaga sistem irigasi, memastikan bahwa kebutuhan air bayam terpenuhi secara konsisten tanpa terjadi over-watering yang dapat merusak akar atau membuang-buang air. Keseimbangan air ini penting agar bayam memiliki tekstur yang ideal dan kandungan klorofil yang tinggi, yang langsung memengaruhi rasa dan nilai gizi camilan akhir.\r\n\r\nAspek inovatif dan keberlanjutan dari budidaya bayam semakin menonjol melalui pemanfaatan pupuk cair alami. Petani muda yang visioner kini menerapkan konsep ekonomi sirkular (lingkar) dalam pertanian mereka, di mana limbah dari proses pengolahan camilan justru diubah menjadi sumber daya baru. Sisa-sisa sayuran, kulit buah pisang, atau bahkan bagian singkong yang tidak terpakai dari proses pembuatan keripik dan smoothie, tidak dibuang begitu saja. Sebaliknya, sisa-sisa organik ini diolah melalui proses fermentasi sederhana menjadi pupuk cair alami, kaya akan unsur hara mikro dan makro yang dibutuhkan bayam. Penggunaan pupuk cair alami ini memiliki dampak ganda: pertama, ia mengurangi biaya pembelian pupuk kimia yang mahal; dan kedua, ia memastikan bahwa bayam ditanam secara organik atau semi-organik, memenuhi permintaan pasar premium yang mencari produk clean-label (berlabel bersih) dan bebas residu kimia.\r\n\r\nSiklus tertutup yang diciptakan oleh praktik ini—dari panen, diolah, dan limbahnya kembali menjadi pupuk untuk panen berikutnya—menjadi Unique Selling Proposition (USP) yang sangat kuat bagi brand camilan sehat para petani muda. Mereka tidak hanya menjual produk yang sehat, tetapi juga sebuah narasi utuh tentang pertanian yang bertanggung jawab dan berkelanjutan. Mereka dapat dengan bangga mengklaim bahwa produk mereka, misalnya Keripik Bayam Organik, dihasilkan melalui proses yang hampir tanpa limbah dan didukung oleh pupuk buatan sendiri. Keunggulan narasi ini memungkinkan mereka mematok harga yang lebih baik dibandingkan produk konvensional, sehingga meningkatkan margin keuntungan dan mendukung harga beli yang adil bagi petani produsen.\r\n\r\nKesuksesan dalam budidaya bayam yang mengombinasikan teknologi presisi (IoT) dan kearifan lokal (pupuk alami) ini kemudian direplikasi pada komoditas lain seperti singkong dan pisang. Filosofi yang sama diterapkan: memonitor kondisi tumbuh yang optimal untuk mencapai kualitas bahan baku terbaik, sambil memaksimalkan penggunaan kembali limbah panen dan pengolahan. Dengan demikian, petani muda telah menciptakan model pertanian yang ideal: efisien berkat data IoT, produktif berkat teknik budidaya yang optimal, dan berkelanjutan berkat sistem pupuk alami dari daur ulang limbah.\r\n\r\nModel pertanian holistik ini adalah bukti nyata evolusi agripreneur muda Indonesia. Mereka telah melangkah jauh melampaui sekadar menanam dan memanen. Mereka mengelola tanah gembur dan air irigasi dengan teknologi termutakhir, sekaligus menerapkan ekonomi sirkular dengan pupuk alami. Inilah yang menjadi fondasi kualitas premium produk olahan mereka—menghasilkan keripik singkong dan smoothie bayam-pisang yang tidak hanya lezat dan sehat, tetapi juga dihasilkan dengan hati-hati dan tanggung jawab penuh terhadap lingkungan, menetapkan standar baru untuk masa depan ketahanan pangan nasional.', 'prd_68dc0331b1ee9.jpeg', '2025-09-05'),
(4, 15, 'Rahasia Bayam Segar dan Hijau', 'Bayam, dengan daun hijaunya yang kaya nutrisi, merupakan komponen penting dalam produk smoothie dan keripik sayur yang ditawarkan oleh petani muda. Untuk mencapai kualitas premium yang dibutuhkan pasar camilan sehat, proses budidaya bayam harus dilakukan dengan cermat dan penuh perhatian terhadap detail lingkungan. Bayam segar tumbuh subur di tanah yang gembur dan kaya bahan organik, memastikan akar dapat menyerap nutrisi secara maksimal. Di sinilah peran sensor IoT yang telah dibahas sebelumnya menjadi sangat vital; sensor tersebut tidak hanya memonitor kelembaban tanah, tetapi juga membantu petani menjaga sistem irigasi, memastikan bahwa kebutuhan air bayam terpenuhi secara konsisten tanpa terjadi over-watering yang dapat merusak akar atau membuang-buang air. Keseimbangan air ini penting agar bayam memiliki tekstur yang ideal dan kandungan klorofil yang tinggi, yang langsung memengaruhi rasa dan nilai gizi camilan akhir.\r\n\r\nAspek inovatif dan keberlanjutan dari budidaya bayam semakin menonjol melalui pemanfaatan pupuk cair alami. Petani muda yang visioner kini menerapkan konsep ekonomi sirkular (lingkar) dalam pertanian mereka, di mana limbah dari proses pengolahan camilan justru diubah menjadi sumber daya baru. Sisa-sisa sayuran, kulit buah pisang, atau bahkan bagian singkong yang tidak terpakai dari proses pembuatan keripik dan smoothie, tidak dibuang begitu saja. Sebaliknya, sisa-sisa organik ini diolah melalui proses fermentasi sederhana menjadi pupuk cair alami, kaya akan unsur hara mikro dan makro yang dibutuhkan bayam. Penggunaan pupuk cair alami ini memiliki dampak ganda: pertama, ia mengurangi biaya pembelian pupuk kimia yang mahal; dan kedua, ia memastikan bahwa bayam ditanam secara organik atau semi-organik, memenuhi permintaan pasar premium yang mencari produk clean-label (berlabel bersih) dan bebas residu kimia.\r\n\r\nSiklus tertutup yang diciptakan oleh praktik ini—dari panen, diolah, dan limbahnya kembali menjadi pupuk untuk panen berikutnya—menjadi Unique Selling Proposition (USP) yang sangat kuat bagi brand camilan sehat para petani muda. Mereka tidak hanya menjual produk yang sehat, tetapi juga sebuah narasi utuh tentang pertanian yang bertanggung jawab dan berkelanjutan. Mereka dapat dengan bangga mengklaim bahwa produk mereka, misalnya Keripik Bayam Organik, dihasilkan melalui proses yang hampir tanpa limbah dan didukung oleh pupuk buatan sendiri. Keunggulan narasi ini memungkinkan mereka mematok harga yang lebih baik dibandingkan produk konvensional, sehingga meningkatkan margin keuntungan dan mendukung harga beli yang adil bagi petani produsen.\r\n\r\nKesuksesan dalam budidaya bayam yang mengombinasikan teknologi presisi (IoT) dan kearifan lokal (pupuk alami) ini kemudian direplikasi pada komoditas lain seperti singkong dan pisang. Filosofi yang sama diterapkan: memonitor kondisi tumbuh yang optimal untuk mencapai kualitas bahan baku terbaik, sambil memaksimalkan penggunaan kembali limbah panen dan pengolahan. Dengan demikian, petani muda telah menciptakan model pertanian yang ideal: efisien berkat data IoT, produktif berkat teknik budidaya yang optimal, dan berkelanjutan berkat sistem pupuk alami dari daur ulang limbah.\r\n\r\nModel pertanian holistik ini adalah bukti nyata evolusi agripreneur muda Indonesia. Mereka telah melangkah jauh melampaui sekadar menanam dan memanen. Mereka mengelola tanah gembur dan air irigasi dengan teknologi termutakhir, sekaligus menerapkan ekonomi sirkular dengan pupuk alami. Inilah yang menjadi fondasi kualitas premium produk olahan mereka—menghasilkan keripik singkong dan smoothie bayam-pisang yang tidak hanya lezat dan sehat, tetapi juga dihasilkan dengan hati-hati dan tanggung jawab penuh terhadap lingkungan, menetapkan standar baru untuk masa depan ketahanan pangan nasional.', 'prd_68dc031a90828.jpg', '2025-09-10'),
(5, 15, 'Pentingnya Sensor IoT di Smart Farm', 'Berdasarkan cerita sebelumnya mengenai petani muda dan inovasi pengolahan hasil panen, informasi baru tentang pemanfaatan Sensor IoT ini adalah kelanjutan logis yang sangat relevan. Saya akan menggabungkannya ke dalam cerita yang berfokus pada efisiensi dan peningkatan kualitas panen, yang akan menjadi fondasi bagi produk camilan sehat premium yang dihasilkan.\r\n\r\nPengembangan Cerita (Menggabungkan IoT dengan Inovasi Petani Muda):\r\n\r\nDi era pertanian modern, inovasi tidak hanya berhenti pada pengolahan pascapanen, tetapi juga merambah ke fase budidaya, dan di sinilah peran teknologi Internet of Things (IoT) menjadi krusial. Sensor-sensor kecil yang terpasang di lahan atau terintegrasi pada tanaman kini dapat membantu petani, khususnya petani muda yang melek teknologi, memantau kondisi esensial seperti suhu, kelembaban tanah dan udara, serta tingkat nutrisi tanaman secara real-time. Data yang dikumpulkan oleh sensor-sensor ini dikirimkan langsung ke aplikasi di ponsel pintar petani, memungkinkan mereka mengambil keputusan yang berbasis data, bukan lagi sekadar perkiraan atau pengalaman semata. Kemampuan untuk mengetahui secara pasti kapan tanaman membutuhkan air, kapan pupuk harus diberikan, dan bagaimana merespons perubahan iklim mendadak, adalah kunci utama yang mendukung peningkatan efisiensi dan produktivitas pertanian secara drastis.\r\n\r\nPemanfaatan IoT secara langsung meningkatkan kualitas dan kuantitas panen komoditas seperti singkong, bayam, dan pisang, yang merupakan bahan baku utama camilan sehat para petani muda. Ketika kelembaban tanah terjaga optimal, tanaman singkong akan menghasilkan umbi yang lebih besar dan memiliki kandungan pati yang ideal untuk keripik renyah. Begitu pula dengan bayam, di mana monitoring nutrisi tanah secara akurat dapat memastikan daun bayam tumbuh subur dengan kandungan vitamin dan mineral yang maksimal, sangat penting untuk smoothie atau bubuk superfood. Efisiensi ini juga mengurangi pemborosan sumber daya; air, pupuk, dan pestisida hanya digunakan seperlunya (presisi farming), yang pada gilirannya menekan biaya operasional secara signifikan dan menjadikan praktik pertanian menjadi lebih ramah lingkungan serta berkelanjutan.\r\n\r\nBagi petani muda yang menjalankan usaha camilan sehat, kualitas bahan baku adalah pembeda utama di pasar premium. Dengan jaminan bahwa bahan baku seperti pisang dan bayam ditanam dalam kondisi ideal yang dimonitor oleh IoT, mereka dapat memberikan label \"Kualitas Terjamin\" atau \"Ditanam dengan Presisi\" pada produk keripik atau smoothie mereka. Hal ini membangun kepercayaan konsumen yang semakin peduli terhadap asal-usul dan proses penanaman pangan mereka. Selain itu, data real-time yang dikumpulkan oleh sensor memungkinkan petani muda untuk merencanakan waktu panen secara optimal. Mereka dapat memanen pisang pada kematangan sempurna untuk rasa manis maksimal, atau bayam pada puncak kandungan nutrisi, memastikan bahwa camilan sehat yang mereka produksi tidak hanya enak, tetapi juga benar-benar memberikan manfaat kesehatan yang dijanjikan.\r\n\r\nIntegrasi teknologi ini secara efektif menutup siklus dari hulu ke hilir. Petani muda kini memiliki keunggulan kompetitif ganda: mereka menggunakan IoT untuk menghasilkan bahan baku berkualitas tinggi secara efisien (Hulu) dan kemudian menggunakan inovasi pengolahan untuk mengubahnya menjadi produk bernilai jual tinggi (Hilir). Hal ini mengubah citra petani dari tenaga kerja kasar menjadi operator teknologi canggih. Investasi awal pada sensor IoT mungkin memerlukan dukungan, tetapi pengembaliannya sangat besar; mengurangi risiko gagal panen, menghemat biaya input, dan yang paling penting, menghasilkan komoditas premium yang menjadi fondasi utama bagi kelangsungan dan pertumbuhan usaha camilan sehat yang kompetitif, menempatkan mereka sebagai pemimpin dalam agripreneurship modern.\r\n\r\nDengan demikian, sensor IoT bukan hanya sekadar alat bantu; ia adalah fondasi vital yang memungkinkan para petani muda mewujudkan visi pertanian presisi. Melalui pemantauan real-time terhadap suhu, kelembaban, dan nutrisi, mereka mengoptimalkan setiap tahapan pertumbuhan, memastikan bahwa setiap singkong, bayam, dan pisang memiliki kualitas terbaik. Peningkatan efisiensi dan produktivitas yang dihasilkan oleh teknologi ini adalah jembatan yang menghubungkan keunggulan panen di lahan dengan kesuksesan produk olahan di pasar, memperkuat posisi petani muda sebagai inovator sejati yang menggabungkan tradisi bertani dengan kecanggihan teknologi demi kemakmuran bersama.', 'prd_68dc02a3a6cc0.jpg', '2025-09-15'),
(6, 15, 'Olahan Sehat dari Hasil Panen', 'Tentu, saya akan kembangkan cerita tersebut menjadi sekitar lima paragraf panjang, sesuai permintaan Anda, dengan fokus pada peluang usaha dan dampak positif bagi petani muda. Karena permintaan Anda dalam bahasa Indonesia, saya akan menggunakan Bahasa Indonesia.\r\n\r\nPengembangan Cerita:\r\n\r\nHasil panen yang melimpah dari lahan pertanian seperti singkong, bayam, dan pisang, seringkali hanya dijual dalam bentuk mentah dengan harga yang fluktuatif, namun di situlah letak potensi luar biasa yang belum tergarap sepenuhnya. Di tengah meningkatnya kesadaran masyarakat akan gaya hidup sehat, komoditas-komoditas sederhana ini dapat bertransformasi menjadi produk bernilai jual tinggi, yaitu camilan sehat yang inovatif. Singkong yang dulunya identik dengan makanan pokok biasa, kini dapat diolah menjadi keripik renyah bebas gluten dengan aneka rasa premium; bayam dapat dikeringkan dan dihaluskan menjadi bubuk superfood atau diolah menjadi crispy veggie chips; sementara pisang matang sempurna bisa diubah menjadi smoothie bowl beku siap saji atau keripik pisang manis gurih. Diversifikasi produk ini tidak hanya mengurangi risiko kerugian akibat anjloknya harga komoditas mentah, tetapi juga memberikan jaminan stabilitas pendapatan yang lebih baik bagi pelaku pertanian.\r\n\r\nTransformasi ini secara langsung membuka pintu lebar bagi munculnya peluang usaha rintisan (startup) di sektor pertanian dan pengolahan pangan, khususnya yang digerakkan oleh para petani muda yang melek teknologi dan pemasaran digital. Petani muda kini tidak lagi hanya berperan sebagai produsen bahan mentah, tetapi juga menjadi agripreneur yang menguasai seluruh rantai nilai, mulai dari penanaman, pengolahan, hingga branding dan distribusi. Mereka dapat memanfaatkan pengetahuan modern untuk mengembangkan metode pengolahan yang higienis dan efisien, seperti teknik pengeringan vakum untuk keripik agar kandungan nutrisinya tetap terjaga, atau pengemasan ramah lingkungan yang menarik perhatian pasar urban. Dengan memanfaatkan platform media sosial dan e-commerce, produk camilan sehat hasil kreasi mereka—mulai dari Keripik Singkong Ubi Ungu hingga Smoothie Pisang Bayam Detox—dapat menjangkau konsumen yang lebih luas, menembus batas-batas geografis pasar tradisional.\r\n\r\nLebih jauh lagi, model bisnis pengolahan hasil panen menjadi camilan sehat ini memiliki potensi besar untuk menciptakan ekosistem bisnis yang inklusif dan berkelanjutan di pedesaan. Peluang usaha ini mendorong kolaborasi yang erat antara petani dan komunitas lokal, di mana petani-petani senior dapat fokus pada budidaya dengan kualitas terbaik, sementara petani muda fokus pada inovasi produk dan operasional bisnis. Proses pengolahan—yang membutuhkan tenaga kerja untuk mencuci, memotong, menggoreng, dan mengemas—dapat menyerap tenaga kerja lokal, terutama perempuan dan pemuda desa, sehingga secara signifikan mengurangi angka pengangguran dan meningkatkan kesejahteraan ekonomi keluarga. Ini adalah sebuah pergeseran paradigma, di mana pertanian tidak lagi hanya dipandang sebagai sektor subsisten, melainkan sebagai mesin pertumbuhan ekonomi daerah yang didorong oleh kreativitas dan nilai tambah.\r\n\r\nKeberhasilan para petani muda dalam mengolah komoditas seperti singkong dan bayam menjadi produk premium juga memberikan dampak edukatif yang kuat bagi masyarakat, sekaligus memperkuat ketahanan pangan lokal. Produk camilan sehat seperti keripik singkong organik atau smoothie bayam-pisang-jahe yang dikemas menarik, membantu mempromosikan konsumsi pangan lokal yang kaya nutrisi sebagai alternatif pengganti makanan ringan impor yang sarat pengawet. Secara tidak langsung, ini juga memberikan insentif kepada petani untuk menerapkan praktik pertanian berkelanjutan, seperti pertanian organik atau tumpang sari, karena permintaan pasar akan bahan baku berkualitas tinggi yang terjamin keamanannya menjadi semakin besar. Dengan demikian, sirkulasi ekonomi berputar di tingkat lokal, menciptakan lingkaran positif antara produksi yang bertanggung jawab, inovasi produk, dan konsumsi yang sehat.\r\n\r\nOleh karena itu, gagasan sederhana untuk mengolah singkong, bayam, dan pisang menjadi keripik dan smoothie adalah katalisator bagi revolusi pertanian skala kecil yang modern. Ini bukan hanya sekadar peluang usaha; ini adalah visi masa depan di mana petani muda menjadi tulang punggung perekonomian desa, memanfaatkan aset alam secara cerdas, dan membuktikan bahwa inovasi pangan lokal dapat bersaing, bahkan memimpin, di pasar camilan global yang menuntut kesehatan dan keberlanjutan. Dukungan pemerintah melalui pelatihan keterampilan, akses permodalan, dan fasilitas pengolahan pascapanen menjadi kunci untuk memastikan bahwa setiap panen dapat bertransformasi maksimal, menghasilkan tidak hanya produk bernilai jual, tetapi juga generasi agripreneur muda yang mandiri, kreatif, dan membawa kesejahteraan bagi komunitasnya.', 'prd_68dc02ed1f3e7.jpg', '2025-09-20'),
(7, 15, 'Masa Depan Pertanian Berkelanjutan', 'Pertanian berkelanjutan merupakan konsep yang menekankan keseimbangan antara kebutuhan manusia untuk memproduksi pangan dan kewajiban menjaga kelestarian alam. Dalam praktiknya, pertanian berkelanjutan tidak hanya berfokus pada hasil panen yang melimpah, tetapi juga pada cara produksi yang tidak merusak ekosistem. Petani berkelanjutan memahami bahwa tanah, air, udara, dan keanekaragaman hayati adalah aset utama yang harus dilestarikan agar generasi mendatang tetap dapat menikmati hasil bumi yang sama. Dengan kata lain, pertanian jenis ini adalah bentuk investasi jangka panjang terhadap kehidupan itu sendiri.\r\n\r\nNamun, upaya menuju pertanian berkelanjutan tidak semudah membalikkan telapak tangan. Pertumbuhan populasi dunia yang pesat menuntut peningkatan produksi pangan dalam skala besar. Di sisi lain, eksploitasi lahan pertanian secara berlebihan telah menyebabkan degradasi tanah, pencemaran air akibat pupuk kimia, serta penurunan kesuburan jangka panjang. Tantangan inilah yang membuat banyak pihak mulai beralih ke metode yang lebih ramah lingkungan. Kesadaran ini juga tumbuh dari pemahaman bahwa kerusakan lingkungan akan berbalik merugikan manusia sendiri, terutama dalam bentuk bencana alam, gagal panen, dan perubahan iklim ekstrem.\r\n\r\nDalam menghadapi tantangan tersebut, teknologi modern menjadi sekutu utama petani masa kini. Inovasi seperti Internet of Things (IoT) dalam pertanian memungkinkan pemantauan kelembapan tanah, suhu, dan kadar nutrisi secara real time. Drone pertanian dapat membantu penyemprotan pupuk atau pestisida organik dengan presisi tinggi, mengurangi pemborosan dan dampak negatif bagi lingkungan. Sementara itu, kecerdasan buatan (AI) digunakan untuk menganalisis data pertanian dalam jumlah besar, membantu petani mengambil keputusan yang lebih tepat tentang waktu tanam, irigasi, dan panen.\r\n\r\nSelain teknologi, penggunaan pupuk organik juga memainkan peran vital dalam menjaga keseimbangan alam. Pupuk organik yang berasal dari limbah pertanian, kotoran ternak, atau kompos alami mampu memperbaiki struktur tanah tanpa meninggalkan residu berbahaya. Dengan cara ini, mikroorganisme tanah tetap hidup dan produktif, menjaga sirkulasi nutrisi alami di ekosistem pertanian. Selain itu, penggunaan pestisida alami berbasis tanaman seperti daun mimba atau serai juga membantu mengendalikan hama tanpa membahayakan manusia dan hewan lain.\r\n\r\nTidak kalah penting, energi terbarukan menjadi pondasi tambahan dalam mendukung pertanian berkelanjutan. Sistem irigasi bertenaga surya, kincir angin untuk pengeringan hasil panen, dan biogas dari limbah ternak merupakan contoh nyata penerapan energi hijau di sektor pertanian. Penggunaan energi terbarukan ini tidak hanya menekan biaya produksi dalam jangka panjang, tetapi juga mengurangi emisi karbon yang menjadi penyebab utama perubahan iklim. Dengan demikian, pertanian tidak hanya menghasilkan pangan, tetapi juga ikut menjaga atmosfer bumi tetap bersih.\r\n\r\nKunci keberhasilan pertanian berkelanjutan sebenarnya bukan hanya pada teknologi, tetapi juga pada pola pikir dan kebijakan. Diperlukan sinergi antara pemerintah, akademisi, pelaku industri, dan masyarakat untuk menciptakan sistem pertanian yang efisien sekaligus ramah lingkungan. Pendidikan bagi petani tentang praktik ramah lingkungan, insentif bagi pengguna teknologi hijau, serta regulasi terhadap penggunaan bahan kimia berbahaya menjadi langkah konkret yang harus dijalankan bersama.\r\n\r\nKe depan, pertanian berkelanjutan akan menjadi fondasi penting bagi ketahanan pangan global. Dunia tidak lagi bisa hanya mengejar produktivitas tanpa memperhatikan keseimbangan ekosistem. Dengan kolaborasi antara teknologi, ilmu pengetahuan, dan kesadaran ekologis, manusia dapat menciptakan sistem pertanian yang mampu memberi makan miliaran orang tanpa mengorbankan masa depan planet ini. Pada akhirnya, pertanian berkelanjutan bukan hanya soal cara bertani — tetapi soal bagaimana manusia belajar hidup selaras dengan alam.', 'prd_68dc03bc2925f.jpg', '2025-09-25');

-- --------------------------------------------------------

--
-- Table structure for table `master_cart`
--

CREATE TABLE `master_cart` (
  `id_cart` int NOT NULL,
  `kode_user` int NOT NULL,
  `kode_produk` varchar(255) NOT NULL,
  `qty` int NOT NULL,
  `harga_satuan` int NOT NULL,
  `subtotal` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `master_cart`
--

INSERT INTO `master_cart` (`id_cart`, `kode_user`, `kode_produk`, `qty`, `harga_satuan`, `subtotal`) VALUES
(17, 15, '12', 1, 1000000, 1000000);

-- --------------------------------------------------------

--
-- Table structure for table `master_kategori`
--

CREATE TABLE `master_kategori` (
  `kode_kategori` int NOT NULL,
  `img` text NOT NULL,
  `nama_kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `master_kategori`
--

INSERT INTO `master_kategori` (`kode_kategori`, `img`, `nama_kategori`) VALUES
(11, 'kat_68dbfa4eb0e6b.png', 'Sayur'),
(12, 'kat_68dbfa6af32d0.png', 'Buah'),
(13, 'kat_68dbfb61d823a.png', 'Herbal'),
(14, 'kat_68dbfb688567a.png', 'Padi'),
(15, 'kat_68dbfbe33e0af.png', 'Palawija'),
(16, 'kat_68dbfb7a6d103.png', 'Benih'),
(17, 'kat_68dbfb8245dd7.png', 'Pupuk'),
(18, 'kat_68dbfb89c9dd5.png', 'Obat'),
(19, 'kat_68dbfb9222dc2.png', 'Alat'),
(20, 'kat_68dbfb9ae8f9e.png', 'Panen'),
(21, 'kat_68dbfba2c1d9d.png', 'Olahan');

-- --------------------------------------------------------

--
-- Table structure for table `master_transaksi`
--

CREATE TABLE `master_transaksi` (
  `id_transaksi` int NOT NULL,
  `kode_transaksi` varchar(500) NOT NULL,
  `kode_user` int NOT NULL,
  `tanggal_transaksi` date NOT NULL,
  `total_harga` int NOT NULL,
  `status` enum('pending','selesai') NOT NULL DEFAULT 'pending',
  `metode_pembayaran` enum('tunai','ovo','gopay','qris') NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `master_transaksi`
--

INSERT INTO `master_transaksi` (`id_transaksi`, `kode_transaksi`, `kode_user`, `tanggal_transaksi`, `total_harga`, `status`, `metode_pembayaran`, `alamat`) VALUES
(63, 'TRX1761141041', 15, '2025-10-22', 4000000, 'selesai', 'ovo', 'Sidoarjo');

-- --------------------------------------------------------

--
-- Table structure for table `master_user`
--

CREATE TABLE `master_user` (
  `kode_user` int NOT NULL,
  `role` enum('admin','pengunjung') NOT NULL DEFAULT 'pengunjung',
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `master_user`
--

INSERT INTO `master_user` (`kode_user`, `role`, `username`, `email`, `password`) VALUES
(14, 'admin', 'admin', 'admin@gmail.com', '$2y$10$V0ETFxhhYJC38mjbmtrXqOWks9PENxcuTqkW0qtpmeLuTVW4LSsge'),
(15, 'pengunjung', 'user', 'user@gmail.com', '$2y$10$kpqmv5uQCm5GIyBl.vDJs.ZqqTuqgLZs58WqBwGUKlIEsOETfnPlG'),
(16, 'pengunjung', 'arek', 'arek@gmail.com', '$2y$10$I9YGZ67WleJgZrdrU0G2NuSCgPIn4KY4FBGU9XqXBd631bjITs.ta');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `kode_produk` varchar(255) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `satuan` varchar(255) NOT NULL,
  `harga` bigint NOT NULL,
  `img` text NOT NULL,
  `stok` int NOT NULL,
  `kode_gudang` varchar(255) NOT NULL,
  `kategori_id` int NOT NULL,
  `deskripsi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`kode_produk`, `nama_barang`, `satuan`, `harga`, `img`, `stok`, `kode_gudang`, `kategori_id`, `deskripsi`) VALUES
('12', 'Benih Bunga Matahari', 'pcs', 1000000, '[\"prd_68f8de06a57a5.png\",\"prd_68f8de06a592a.png\",\"prd_68f8de06a5a8a.jpg\",\"prd_68f8de06a5b90.jpg\"]', 40, '6', 16, 'Benih Bunga'),
('13', 'Pupuk ', 'kg', 20000, '[\"prd_68f8ddf53cacd.png\",\"prd_68f8ddf53cc53.png\",\"prd_68f8ddf53cd80.jpg\",\"prd_68f8ddf53fed5.jpg\"]', 66, '6', 17, 'Pupuk Besar'),
('34', 'Tomat', 'kg', 15000, '[\"prd_68f8dde72261f.png\",\"prd_68f8dde7228b0.png\",\"prd_68f8dde722a62.jpg\",\"prd_68f8dde727e63.png\"]', 46, 'GD00A', 11, 'Tomat segar langsung dari kebun hidroponik'),
('35', 'Semangka', 'kg', 12000, '[\"prd_68f8ddcab0012.png\",\"prd_68f8ddcab02c4.png\",\"prd_68f8ddcab03fe.png\",\"prd_68f8ddcab0557.jpg\"]', 40, '6', 12, 'Semangka manis dan berair'),
('36', 'Kunyit', 'kg', 25000, '[\"prd_68f8ddbf80e43.png\",\"prd_68f8ddbf81065.png\",\"prd_68f8ddbf811d5.jpg\",\"prd_68f8ddbf81302.jpg\"]', 59, '7', 13, 'Kunyit segar untuk herbal dan bumbu'),
('37', 'Cangkul', 'pcs', 50000, '[\"prd_68f8dda3e9d6e.png\",\"prd_68f8dda3e9efc.png\",\"prd_68f8dda3ea034.png\",\"prd_68f8dda3ea185.jpg\"]', 0, '8', 19, 'Alat pertanian untuk menggemburkan tanah'),
('38', 'Keripik Bayam', 'pcs', 10000, '[\"prd_68f8dd965e4b3.png\",\"prd_68f8dd965e63b.png\",\"prd_68f8dd965e76f.png\",\"prd_68f8dd965e875.jpg\"]', 100, 'GD00AB', 21, 'Camilan sehat berbahan bayam segar'),
('P001', 'Bayam', 'gram', 20000, '[\"prd_68f8dd2c2a499.png\",\"prd_68f8dd2c2a61f.png\",\"prd_68f8dd2c2a755.png\",\"prd_68f8dd2c2a854.jpg\"]', 28, '6', 11, 'Bayam Segarr Menyehatkan'),
('P002', 'Jamu', 'liter', 20000, '[\"prd_68f8dd6c79754.png\",\"prd_68f8dd6c79904.png\",\"prd_68f8dd6c7cb53.png\",\"prd_68f8dd6c7ccb3.jpg\"]', 22, '7', 13, 'Jamu Segar'),
('P003', 'Jeruk', 'kg', 20000, '[\"prd_68f8dd7fd23ef.png\",\"prd_68f8dd7fd2672.png\",\"prd_68f8dd7fd27de.png\",\"prd_68f8dd7fd291c.jpg\"]', 3, 'GD00A', 12, 'Jeruk Yang Sangat Enak');

-- --------------------------------------------------------

--
-- Table structure for table `produks_ratings`
--

CREATE TABLE `produks_ratings` (
  `id_rating` int NOT NULL,
  `user_id` int NOT NULL,
  `kode_produk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `kode_transaksi` varchar(500) NOT NULL,
  `rating` int NOT NULL,
  `comment` text NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `produks_ratings`
--

INSERT INTO `produks_ratings` (`id_rating`, `user_id`, `kode_produk`, `kode_transaksi`, `rating`, `comment`, `created_at`) VALUES
(13, 15, '12', 'TRX1761141041', 4, 'Bagus, Tumbuh Dengan Baik', '2025-10-22 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `transaksi_detail` (`id_transaksi`),
  ADD KEY `detail_barang` (`kode_produk`);

--
-- Indexes for table `gudang`
--
ALTER TABLE `gudang`
  ADD PRIMARY KEY (`kode_gudang`);

--
-- Indexes for table `master_blog`
--
ALTER TABLE `master_blog`
  ADD PRIMARY KEY (`id_blog`),
  ADD KEY `user_blog` (`kode_user`);

--
-- Indexes for table `master_cart`
--
ALTER TABLE `master_cart`
  ADD PRIMARY KEY (`id_cart`),
  ADD KEY `user_cart` (`kode_user`),
  ADD KEY `cart_barang` (`kode_produk`);

--
-- Indexes for table `master_kategori`
--
ALTER TABLE `master_kategori`
  ADD PRIMARY KEY (`kode_kategori`);

--
-- Indexes for table `master_transaksi`
--
ALTER TABLE `master_transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD UNIQUE KEY `kode_transaksi` (`kode_transaksi`),
  ADD KEY `user_transaksi` (`kode_user`);

--
-- Indexes for table `master_user`
--
ALTER TABLE `master_user`
  ADD PRIMARY KEY (`kode_user`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`kode_produk`),
  ADD KEY `barang_gudang` (`kode_gudang`),
  ADD KEY `kategori_barang` (`kategori_id`);

--
-- Indexes for table `produks_ratings`
--
ALTER TABLE `produks_ratings`
  ADD PRIMARY KEY (`id_rating`),
  ADD KEY `user_rating` (`user_id`),
  ADD KEY `product_rating` (`kode_produk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT for table `master_blog`
--
ALTER TABLE `master_blog`
  MODIFY `id_blog` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `master_cart`
--
ALTER TABLE `master_cart`
  MODIFY `id_cart` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `master_kategori`
--
ALTER TABLE `master_kategori`
  MODIFY `kode_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `master_transaksi`
--
ALTER TABLE `master_transaksi`
  MODIFY `id_transaksi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `master_user`
--
ALTER TABLE `master_user`
  MODIFY `kode_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `produks_ratings`
--
ALTER TABLE `produks_ratings`
  MODIFY `id_rating` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD CONSTRAINT `produk_transaksi` FOREIGN KEY (`kode_produk`) REFERENCES `produk` (`kode_produk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `transaksi_detail` FOREIGN KEY (`id_transaksi`) REFERENCES `master_transaksi` (`id_transaksi`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `master_blog`
--
ALTER TABLE `master_blog`
  ADD CONSTRAINT `user_blog` FOREIGN KEY (`kode_user`) REFERENCES `master_user` (`kode_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `master_cart`
--
ALTER TABLE `master_cart`
  ADD CONSTRAINT `produk_cart` FOREIGN KEY (`kode_produk`) REFERENCES `produk` (`kode_produk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_cart` FOREIGN KEY (`kode_user`) REFERENCES `master_user` (`kode_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `master_transaksi`
--
ALTER TABLE `master_transaksi`
  ADD CONSTRAINT `user_transaksi` FOREIGN KEY (`kode_user`) REFERENCES `master_user` (`kode_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `gudang_produk` FOREIGN KEY (`kode_gudang`) REFERENCES `gudang` (`kode_gudang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `kategori_barang` FOREIGN KEY (`kategori_id`) REFERENCES `master_kategori` (`kode_kategori`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `produks_ratings`
--
ALTER TABLE `produks_ratings`
  ADD CONSTRAINT `produk_rating` FOREIGN KEY (`kode_produk`) REFERENCES `produk` (`kode_produk`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_rating` FOREIGN KEY (`user_id`) REFERENCES `master_user` (`kode_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
