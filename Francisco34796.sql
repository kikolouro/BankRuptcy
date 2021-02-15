-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 26, 2019 at 02:12 PM
-- Server version: 5.5.37
-- PHP Version: 5.3.10-1ubuntu3.11

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `Francisco34796`
--

-- --------------------------------------------------------

--
-- Table structure for table `Conta`
--

CREATE TABLE IF NOT EXISTS `Conta` (
  `IBAN` bigint(20) unsigned NOT NULL,
  `saldo` decimal(11,0) NOT NULL,
  `limite` int(11) DEFAULT NULL,
  `idconta` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` varchar(20) NOT NULL,
  PRIMARY KEY (`idconta`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `Conta`
--

INSERT INTO `Conta` (`IBAN`, `saldo`, `limite`, `idconta`, `tipo`) VALUES
(234234234234, 100, 0, 3, '2'),
(112, 1006, 0, 2, '2'),
(123, 1000, 0, 4, '1'),
(123123, 500, 2500, 6, '3');

-- --------------------------------------------------------

--
-- Table structure for table `TipoConta`
--

CREATE TABLE IF NOT EXISTS `TipoConta` (
  `idTipo` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Tipo` varchar(20) NOT NULL,
  PRIMARY KEY (`idTipo`),
  UNIQUE KEY `idTipo` (`idTipo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `TipoConta`
--

INSERT INTO `TipoConta` (`idTipo`, `Tipo`) VALUES
(1, 'Múltipla'),
(2, 'Singular'),
(3, 'Poupança');

-- --------------------------------------------------------

--
-- Table structure for table `TipoUtilizador`
--

CREATE TABLE IF NOT EXISTS `TipoUtilizador` (
  `idTipoUser` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `TipoUser` varchar(20) NOT NULL,
  PRIMARY KEY (`idTipoUser`),
  UNIQUE KEY `idTipoUser` (`idTipoUser`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `TipoUtilizador`
--

INSERT INTO `TipoUtilizador` (`idTipoUser`, `TipoUser`) VALUES
(1, 'Cliente'),
(2, 'Funcionario'),
(3, 'Administrador');

-- --------------------------------------------------------

--
-- Table structure for table `Transacao`
--

CREATE TABLE IF NOT EXISTS `Transacao` (
  `idtrans` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Mensagem` varchar(200) DEFAULT NULL,
  `Valor` int(11) NOT NULL,
  `IbanReceb` char(20) NOT NULL,
  `creditoDebito` char(20) DEFAULT NULL,
  `data` datetime DEFAULT NULL,
  `idconta` char(20) NOT NULL,
  PRIMARY KEY (`idtrans`),
  UNIQUE KEY `idtrans` (`idtrans`),
  UNIQUE KEY `idtrans_2` (`idtrans`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

--
-- Dumping data for table `Transacao`
--

INSERT INTO `Transacao` (`idtrans`, `Mensagem`, `Valor`, `IbanReceb`, `creditoDebito`, `data`, `idconta`) VALUES
(15, 'teste', 500, '123123', 'Débito', '2019-10-18 09:37:53', '3'),
(14, 'teste', 500, '123123', 'Crédito', '2019-10-18 09:37:53', '3'),
(11, 'www', 402, '112', 'Crédito', '2019-10-14 16:10:35', '4'),
(12, 'www', 402, '112', 'Débito', '2019-10-14 16:10:35', '4');

-- --------------------------------------------------------

--
-- Table structure for table `UserRedes`
--

CREATE TABLE IF NOT EXISTS `UserRedes` (
  `iduti` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Nome` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Pass` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`iduti`),
  UNIQUE KEY `iduti` (`iduti`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci AUTO_INCREMENT=4 ;



--
-- Table structure for table `uticonta`
--

CREATE TABLE IF NOT EXISTS `uticonta` (
  `iduti` char(20) NOT NULL,
  `idconta` char(20) NOT NULL,
  PRIMARY KEY (`iduti`,`idconta`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `uticonta`
--

INSERT INTO `uticonta` (`iduti`, `idconta`) VALUES
('6', '2'),
('6', '4'),
('6', '5'),
('7', '3'),
('7', '6');

-- --------------------------------------------------------

--
-- Table structure for table `Utilizador`
--

CREATE TABLE IF NOT EXISTS `Utilizador` (
  `CC` int(11) NOT NULL,
  `Nome` varchar(80) NOT NULL,
  `Login` varchar(20) DEFAULT NULL,
  `Pass` varchar(120) DEFAULT NULL,
  `Foto` varchar(50) DEFAULT NULL,
  `datanasc` date NOT NULL,
  `email` varchar(200) DEFAULT NULL,
  `morada` varchar(200) DEFAULT NULL,
  `telefone` int(11) NOT NULL,
  `cargo` int(11) DEFAULT NULL,
  `iduti` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `Verificacao` varchar(200) NOT NULL,
  PRIMARY KEY (`iduti`),
  UNIQUE KEY `telefone` (`telefone`),
  UNIQUE KEY `Login` (`Login`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=35 ;

--
-- Dumping data for table `Utilizador`
--

INSERT INTO `Utilizador` (`CC`, `Nome`, `Login`, `Pass`, `Foto`, `datanasc`, `email`, `morada`, `telefone`, `cargo`, `iduti`, `Verificacao`) VALUES
(0, 'admin', 'admin', '$6$UVADts8u$wPjGENK9HdmBSKsNkzmczL796bMoaFJJxOvkUrcAKPvdPuVK4a0/4mlpfw6mTzSmQfH8/QspouCiAaRFU3CXC.', './img/user.jpg', '2019-10-02', '', '', 0, 3, 7, 'Verificado'),
(12312322, 'kiko', 'kiko@33', '$6$Qq4oSMfJ$5ubI9yh1J1tNnpDLovzWr7859DssaW5OLCCDpc8vL0UpN4k86rHMpk5vVlqPekMu46WkM4joAJb1cAISHOCGJ/', './img/user.jpg', '2000-11-06', 'francisco.louro16@hotmail.com', 'asdasd', 678676676, 1, 34, '5ddd1e3b22c46-5ddd1e3b22c9b'),
(0, 'teste', 'teste', '$6$ilYv1pkI$v406pTEj1a4fw9zGvp5XVHrhBzWiWY82Yk9LjOCdtnGkCMsMxpQvcfXShw8I9c22gKAW9AkyOOiFq0d/fTUul.', './img/user.jpg', '0000-00-00', '', '.', 2147483647, 1, 6, ''),
(2147483647, 'o meu nome', 'omeunome@13', '$6$VpoxcpQH$4nUXRzDcXzyKBsvkD4IJ9CUpY2AkdzgPrsELQC9sOh68RwrfsAGCHfNNSy.KIiCo15vp0J0sfH0mCJJbXvMic0', './img/omeunome@13.jpg', '2019-10-23', 'email@email.email', 'sinvwsvsdvsdfv', 912344444, 1, 14, ''),
(63463456, 'asdf', 'asdf@15', '$6$Xc1gSme1$5Wr6Fxzpj9q/guXRU2QT9UsWkPr6hAQHkjU7/9GRafSdbpLkIvQXzwth6JIghzda9xazm.o5tKUul4egjiIVM0', './img/asdf@15.jpg', '2019-10-24', 'nojsdvjnsdvj@sdfa.com', 'q3rq3rqr', 912334433, 1, 15, ''),
(239429384, 'imadvikmsdv', 'imadvikmsdv@20', '$6$8PoS2QqX$8.Uhq31mmc4V7KgKau7ZyhsxhMHUVxkSR47hk2bCln3Tuvi8nHCUor.v8z2L6p2RgHuopirCk31fOK68fDMn7.', './img/user.jpg', '2222-02-22', 'pemisam@7dmail.com', 'q3rq3rqr', 132213213, 1, 20, '5db6b0a345ef1-5db6b0a345f2e'),
(2147483647, 'quweyuqwer', 'quweyuqwer@17', '$6$Ym.FRv7g$FHDMPg4BPgckgbxZkZtd3DmEhdCfk6ZloFl7I/dRRokrYHpUzg9.vZlEaUq.2kHPN.R6G7lOYH5fnY1HNiC240', './img/user.jpg', '2019-10-28', 'nojsdvjnsdvj@sdfa.com', 'unsdfvjnidfjv', 123, 1, 17, ''),
(12312311, 'a', 'a@23', '$6$M05khkUv$SqKxFskHiEyB/6ENbFLngLRiUnjRt5UMLQQtgptY5h/jzNF70dLwPzPhu1Hla2l2G3GFhNluz3vLQZhLrbbfn0', './img/user.jpg', '2019-11-07', 'pemisam@7dmail.com', '', 213123321, 1, 23, '5dc3f6cc6ee75-5dc3f6cc6eeb3'),
(2147483647, 'snuvjinsdvni', 'snuvjinsdvni@19', '$6$Ds.Srd8R$6N7qqeDpbmV01MIygQhQlG1YoQVy.d1Xz.SuL7cncGL5K6lzp.MzSK3Gpg/etCPGlOYgW7gt6pVj/kFYY7IYg/', './img/user.jpg', '2019-10-28', 'pemisam@7dmail.com', '123123123', 123123, 1, 19, '5db6af5746035-5db6af5746072'),
(2147483647, 'qweqweqwe', 'qweqweqwe@21', '$6$vern3kFU$UCpPa6JyavNP8Z8s6cdMOTeEROFqTl.19Ml2GcYrvRSW1.Pk8e3FMDoRy3IneQbATvt9N20QZmVGzAY66KBhM1', './img/user.jpg', '2019-10-04', 'pemisam@7dmail.com', '12312312312', 123123123, 1, 21, '5db6b244265d6-5db6b24426613'),
(28937482, 'sdv', 'sdv@28', '$6$amcJrTnL$RmkK7O5WJ7/DObeJs6B/7pG3xolYSsL2drCBX6Y.Fsk/6CYQQmwXas2cH337Me3ACus4sRlmB49sQKFllI7LR.', './img/user.jpg', '2000-11-27', 'francisco.louro16@hotmail.com2\n', 'ngrewrgertg', 123321221, 1, 28, '5dc52cf390b9b-5dc52cf390bd8'),
(12332122, 'Francisco Rafael', 'FranciscoRafael@29', '$6$w.tQYhy1$Aji45brFQW3Au6YWN3citeTRWaGtuAOH/Pmc8.FYJQxOqhxXY1vDgEGLVEVm1zP8jv669IYjBuNY7CohWlO2t.', './img/user.jpg', '1999-02-02', 'kikorafael1@gmail.com', 'wjknmfvwjrvm', 892734234, 1, 29, '5dc91ecdd1d6e-5dc91ecdd1dab'),
(43223422, 'kiko', 'kiko@25', '$6$Mi/Id4Ei$tcS3JqmD6rGfDukDJ2IxKKrTDwr0p9QRb0QpdKgCNLybrlgZ3DXLl1oPIftsYwt9vcXwHoz.ItXMk9/h4X20a/', './img/user.jpg', '2000-02-22', 'nob98739@bcaoo.com', '', 987654321, 1, 26, '5dc3fc539554a-5dc3fc5395587'),
(24562244, 'Filipe', 'Filipe@27', '$6$doqeUN7R$FJ8GqeEjmRs1YcUYDaWP9574HAD8TuFLv7ZKl7V.0ng410rJOUvK95ZxJGVRh/0PNYNKPhjjoviM9gY4LVwY21', './img/user.jpg', '2000-02-17', 'bde65029@eveav.com', 'uohbyuvbi', 565323552, 1, 27, '5dc41eb176cfc-5dc41eb176d39'),
(25555555, 'HackerPT', 'HackerPT@30', '$6$Xl0g./ry$8igmE0RwJI80V7YZttUCU1bn1rtXjJMnEj9hIETu5Y1l9CIrdIVgJVmdooQkn0HsHg8wnF6/II4AHZcU5qc001', './img/user.jpg', '1657-10-11', 'yoooo@hacker.hacker', '13123131231231 Hacker City', 913321312, 1, 30, '5dcac8429731f-5dcac8429735c'),
(12332122, 'aaaa', 'aaaa@31', '$6$8DF5TRdh$q.NqEORa/QV9AMZrNDzw2hyrC2QAIJ454IOFQ9en04k0t8GclX8agbZ1uDUGiRBofC/pNmTTFNUxFD8umxM6A/', './img/user.jpg', '1500-02-22', 'exemplo@bankruptcy.pt', 'adad', 912345678, 1, 31, '5dcac94b776d3-5dcac94b7770f'),
(13332223, 'vvv', 'vvv@32', '$6$F9wgfwhX$dS4.MOCVASqYNDA6SZ5z87nH/iZehcLSSnMT7Dt3V5mgUkwTVP1YpyvvFnvPULqGIQ6tREMXmPBnA/gMDoj0X0', './img/vvv@32.jpg', '2000-02-22', 'francisco.louro11@hotmail.com', 'ad', 912345676, 1, 32, '5dcaca581fc1c-5dcaca581fc58');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
