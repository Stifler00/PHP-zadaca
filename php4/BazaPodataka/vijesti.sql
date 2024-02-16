-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 16, 2024 at 09:05 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `php-zadaca`
--

-- --------------------------------------------------------

--
-- Table structure for table `vijesti`
--

CREATE TABLE `vijesti` (
  `id` int(3) NOT NULL,
  `datum` datetime NOT NULL DEFAULT current_timestamp(),
  `naslovna_slika` varchar(512) NOT NULL,
  `naslov` varchar(128) NOT NULL,
  `sadrzaj` longtext NOT NULL,
  `arhivirano` tinyint(1) NOT NULL DEFAULT 0,
  `approved` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vijesti`
--

INSERT INTO `vijesti` (`id`, `datum`, `naslovna_slika`, `naslov`, `sadrzaj`, `arhivirano`, `approved`) VALUES
(1, '2024-02-11 00:00:00', 'objava1.jpg', 'Rijeka je dobila na samopouzdanju. Titula? To su priče za malu djecu', 'Jedini pogodak na utakmici zabio je Niko Janković iz jedanaesterca u 63. minuti, nakon što je Filip Krovinović igrao rukom u svom kaznenom prostoru. Rijeka je s 22 boda prestigla Hajduk, koji je ostao na drugom mjestu s 21 bodom. \r\nUtakmicu nam je prokomentirao nekadašnji golman Rijeke Ivan Vargić. Osječanin je branio za Rijeku od 2013. do 2016. godine te osvojio s njom Kup, prije nego što ga je kupio Lazio.\r\nBio je i golman hrvatske reprezentacije. Za igrače, stručni stožer i navijače svog nekadašnjeg kluba imao je samo riječi hvale.\r\nU jednoj fer i korektnoj utakmici punoj tempa Rijeka je zasluženo upisala tri boda, a Armada je pokazala kako se bodri i navija za svoj klub i svoj grad. Kapa do poda igračima Rijeke, stručnom stožeru i navijačima na današnjoj predstavi koja je završila na najbolji mogući način za njih.\r\nTo su priče za malu djecu, deset kola je prošlo, ima još 26 kola za igrati, a za danas je jedino bitna pobjeda u derbiju, koja će, siguran sam, dodatno podignuti samopouzdanje riječkoj momčadi. Ali mora se reći i da imaju jako dobru ekipu koja jako dobro igra.', 0, 1),
(2, '2024-02-11 00:00:00', 'objava2.jpg', 'Jokić je lani bio najplaćeniji igrač u NBA-u, a uskoro neće biti ni u svojoj momčadi', 'U međuvremenu ga je prestigao Jaylen Brown iz Bostona s 303 milijuna, a uskoro Jokić više neće biti ni najbolje plaćen igrač svoje momčadi.\r\nVeć idućeg ljeta takav će ugovor potpisati i Kanađanin Jamal Murray ako u nadolazećoj sezoni bude izabran u jednu od najbolje tri petorke lige, All-NBA.\r\nTo je uvjet koji mu omogućuje da potpiše supermax ugovor, kao što je lani učinio Jokić. Samo, visina supermaxa ovisi o razini salary capa, a kako on svake godine raste, tako raste i najveća moguća visina ugovora.\r\nZato je Brownov ovogodišnji supermax veći od lanjskog Jokićevog i zato će iduće sezone biti još viši, iako se trenutačno ne može precizirati koliki, ali vjerojatno preko 330 milijuna.\r\n\"Pretpostavljamo da ćemo mu ponuditi supermax, vjerojatno će biti All-NBA\", rekao je generalni menadžer Calvin Booth. \"Vlasnici Nuggetsa Josh i Stan Kroenke njegovi su veliki fanovi, pa, ako ispuni uvjet i bude All-NBA, mi ćemo učiniti ono što je na nama.\"', 0, 1),
(3, '2024-02-11 19:29:31', 'objava3.jpg', 'Bivši igrači Barcelone i dalje dolaze u Miami. Stiže i Messijev omiljeni suigrač?', 'Puno je vjerojatnije da će se klub iz Miamija posvetiti izgradnji ekipe za nadolazeću sezonu oko Messija, kojemu će to biti prva cjelovita sezona u SAD-u.\r\nPotaknuti Messijevim potpisom za Inter Miami, momčadi su se ovog ljeta pridružili i Sergio Busquets te Jordi Alba, Messijevi bivši dugogodišnji suigrači iz Barcelone.\r\nLako je moguće da njih dvojica neće biti jedini bivši igrači Barcelone koji će se pridružiti Messiju u Miamiju.\r\nKako javlja talijanski insajder Nicolo Schira, Urugvajac Luis Suarez na kraju godine će napustiti brazilski Gremio, a Inter Miami ga želi dovesti. Suarez i Messi jako su dobro surađivali u Barceloni te su postali i veliki prijatelji izvan terena pa se stoga ovaj transfer čini kao vrlo realna opcija.\r\nSuarez poput Messija ima 36 godina, a ove je godine za Gremio u 42 nastupa zabio 20 golova.', 0, 0),
(4, '2024-02-11 19:31:47', 'objava4.jpg', 'Golman Hajduka se poigravao na crti prije penala. Slijedio je hladnokrvan potez', 'RIJEKA je u derbiju 11. kola SuperSport HNL-a na Rujevici s 1:0 pobijedila Hajduk i preuzela vrh ljestvice. Strijelac za Rijeku je bio Niko Janković s bijele točke u 63. minuti.\r\nStrijelac za Rijeku je bio Niko Janković s bijele točke u 63. minuti. Penal je skrivio Filip Krovinović igranjem rukom. Posebno je zanimljiv bio sam trenutak izvođenja penala.\r\nNaime, golman Hajduka Ivan Lučić je pokušao dekoncentrirati Jankovića tako što se okrenuo bočno prema veznjaku Rijeke, što nije uobičajeno ponašanje golmana prije izvođenja kaznenog udarca.\r\nUsprkos tome, Janković se nije dao smesti, već je ostao potpuno hladan.\r\nVeznjak Rijeke je snažno opalio loptu po sredini gola pod samu gredu i hladnokrvno matirao Lučića kojem bi taj udarac bilo teško obraniti čak i da je bio postavljen točno na sredini gola. ', 0, 1),
(5, '2024-02-11 19:33:16', 'objava5.jpg', 'Sepp Blatter napao FIFA-u: Ovo je apsurdno', 'BIVŠI predsjednik FIFA-e Sepp Blatter kritizirao je odluku krovnog tijela svjetskog nogometa da se Svjetsko prvenstvo 2030. godine održi u šest zemalja na tri kontinenta. Maroko, Španjolska i Portugal imenovani su domaćinima turnira 2030., ali prve će se utakmice igrati u Urugvaju, Argentini i Paragvaju povodom obilježavanja stote obljetnice turnira, objavila je FIFA u iznenadnoj objavi u srijedu.\r\nOdluku je kritizirao Sepp Blatter, koji je bio predsjednik FIFA-e od 1998. do 2015., prije nego što je smijenjen nakon istrage o korupciji. \"Apsurdno je rasturiti mundijal na ovaj način.\r\nZavršnica Svjetskog prvenstva mora biti kompaktan događaj\", rekao je Blatter za švicarske novine SonntagsBlick, dodavši da je to važno za identitet događaja, za organizaciju i za posjetitelje.\r\nBlatter, nekoć jedna od najmoćnijih figura u nogometu, ranije je kritizirao FIFA-u jer je Kataru dodijelila prvenstvo 2022., rekavši da je zemlja Bliskog istoka jednostavno premala.\r\nOvaj 87-godišnjak je rekao da bi se turnir 2030. trebao održati u Južnoj Americi, obilježavajući 100. godišnjicu prvog turnira koji je organizirao i osvojio Urugvaj: \"Iz povijesnih razloga Svjetsko prvenstvo 2030. trebalo je pripasti isključivo Južnoj Americi.\"\r\n', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vijesti`
--
ALTER TABLE `vijesti`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vijesti`
--
ALTER TABLE `vijesti`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
