-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2025 at 07:18 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gourmet_discoveries`
--

-- --------------------------------------------------------

--
-- Table structure for table `recipes`
--

CREATE TABLE `recipes` (
  `id` int(11) NOT NULL,
  `meal_id` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL,
  `area` varchar(100) DEFAULT NULL,
  `instructions` text DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `meal_id`, `name`, `category`, `area`, `instructions`, `thumbnail`, `tags`, `created_at`) VALUES
(1, 53073, 'Eggplant Adobo', 'Vegetarian', 'Filipino', '1.	Slice 1 lb. small Japanese or Italian eggplant (about 3) into quarters lengthwise, then cut crosswise into 2\"-wide pieces. Place in a medium bowl. Add 1 Tbsp. sugar, 1 tsp. Diamond Crystal or ½ tsp. Morton kosher salt, and ½ tsp. freshly ground black pepper. Toss to evenly coat eggplant and let sit at room temperature at least 20 minutes and up to 2 hours.\r\n2.	Peel and thinly slice 8 garlic cloves. Add 3 Tbsp. vegetable oil and half of garlic to a medium Dutch oven or other heavy pot. Cook over medium-high heat, stirring constantly with a wooden spoon, until light golden and crisp, about 5 minutes. Using a slotted spoon, transfer garlic chips to a plate; season lightly with salt.\r\n3. Place 4 oz. ground pork in same pot and break up into small pieces with wooden spoon. Season with ¼ tsp. Diamond Crystal or Morton kosher salt and cook, undisturbed, until deeply browned underneath, about 5 minutes. Using a slotted spoon, transfer to another plate, leaving fat behind in the pot.\r\n4. Place eggplant on a clean kitchen towel and blot away any moisture the salt has drawn out.\r\n5. Working in batches and adding more oil if needed, cook eggplant in the same pot until lightly browned, about 3 minutes per side. Transfer to a plate with pork.\r\n6. Pour 1½ cups of water into the pot and scrape up browned bits from the bottom with a wooden spoon. Add remaining garlic, 3 Tbsp. coconut vinegar or unseasoned rice vinegar, 2 Tbsp. soy sauce, 2 bay leaves, 1 tsp. freshly ground black pepper, and remaining 1 Tbsp. sugar. Bring to a simmer, then return pork and eggplant to pot. Reduce heat to medium-low, partially cover, and simmer until eggplant is tender and silky and sauce is reduced by half, 20–25 minutes. Taste and season with more salt and pepper and add a little more sugar if needed.\r\n7. Top with garlic chips and serve with cooked white rice.\r\n', 'https://www.themealdb.com/images/media/meals/y7h0lq1683208991.jpg', '', '2025-12-04 05:57:16'),
(2, 53072, 'Crispy Eggplant', 'Vegetarian', 'Filipino', 'Slice eggplant into 1 cm (0.4-inch) slices. Place them in a bowl and sprinkle them with salt. allow them to sit for 30 minutes to render some of their liquid and bitterness.\r\n2. After 30 minutes wash eggplant slices from salt and pat dry with a kitchen towel.\r\n3. In a large bowl/plate place breadcrumbs and sesame seeds. In another bowl beat 2 eggs with pinch salt and pepper.\r\n4. Heal oil in a large skillet over high heat.\r\n5. Dip eggplant slices in egg, then in crumbs, and place in hot oil. Fry 2 to 3 minutes on each side, or until golden brown. Drain on a paper towel. \r\n', 'https://www.themealdb.com/images/media/meals/c7lzrl1683208757.jpg', '', '2025-12-04 06:15:01'),
(3, 53236, 'Vietnamese-style veggie hotpot', 'Vegetarian', 'Vietnamese', 'step 1\r\nHeat the oil in a medium-size, lidded saucepan. Add the ginger and garlic, then stir-fry for about 5 mins. Add the squash, soy sauce, sugar and stock. Cover, then simmer for 10 mins. Remove the lid, add the green beans, then cook for 3 mins more until the squash and beans are tender. Stir the spring onions through at the last minute, then sprinkle with coriander and serve with rice.', 'https://www.themealdb.com/images/media/meals/4uje7l1763762276.jpg', '', '2025-12-04 06:15:01'),
(5, 52975, 'Tuna and Egg Briks', 'Seafood', 'Tunisian', 'Heat 2 tsp of the oil in a large saucepan and cook the spring onions over a low heat for 3 minutes or until beginning to soften. Add the spinach, cover with a tight-fitting lid and cook for a further 2–3 minutes or until tender and wilted, stirring once or twice. Tip the mixture into a sieve or colander and leave to drain and cool.\r\nUsing a saucer as a guide, cut out 24 rounds about 12.5 cm (5 in) in diameter from the filo pastry, cutting 6 rounds from each sheet. Stack the filo rounds in a pile, then cover with cling film to prevent them from drying out.\r\nWhen the spinach mixture is cool, squeeze out as much excess liquid as possible, then transfer to a bowl. Add the tuna, eggs, hot pepper sauce, and salt and pepper to taste. Mix well.\r\nPreheat the oven to 200°C (400°F, gas mark 6). Take one filo round and very lightly brush with some of the remaining oil. Top with a second round and brush with a little oil, then place a third round on top and brush with oil.\r\nPlace a heaped tbsp of the filling in the middle of the round, then fold the pastry over to make a half-moon shape. Fold in the edges, twisting them to seal, and place on a non-stick baking sheet. Repeat with the remaining pastry and filling to make 8 briks in all.\r\nLightly brush the briks with the remaining oil. Bake for 12–15 minutes or until the pastry is crisp and golden brown.\r\nMeanwhile, combine the tomatoes and cucumber in a bowl and sprinkle with the lemon juice and seasoning to taste. Serve the briks hot with this salad and the chutney.', 'https://www.themealdb.com/images/media/meals/2dsltq1560461468.jpg', '', '2025-12-04 06:15:01'),
(6, 52962, 'Salmon Eggs Eggs Benedict', 'Breakfast', 'American', 'First make the Hollandaise sauce. Put the lemon juice and vinegar in a small bowl, add the egg yolks and whisk with a balloon whisk until light and frothy. Place the bowl over a pan of simmering water and whisk until mixture thickens. Gradually add the butter, whisking constantly until thick – if it looks like it might be splitting, then whisk off the heat for a few mins. Season and keep warm.\r\n\r\nTo poach the eggs, bring a large pan of water to the boil and add the vinegar. Lower the heat so that the water is simmering gently. Stir the water so you have a slight whirlpool, then slide in the eggs one by one. Cook each for about 4 mins, then remove with a slotted spoon.\r\n\r\nLightly toast and butter the muffins, then put a couple of slices of salmon on each half. Top each with an egg, spoon over some Hollandaise and garnish with chopped chives.', 'https://www.themealdb.com/images/media/meals/1550440197.jpg', 'Bun,Brunch', '2025-12-04 06:15:01'),
(7, 52955, 'Egg Drop Soup', 'Vegetarian', 'Chinese', 'In a wok add chicken broth and wait for it to boil.\r\nNext add salt, sugar, white pepper, sesame seed oil.\r\nWhen the chicken broth is boiling add the vegetables to the wok.\r\nTo thicken the sauce, whisk together 1 Tablespoon of cornstarch and 2 Tablespoon of water in a bowl and slowly add to your soup until it\'s the right thickness.\r\nNext add 1 egg slightly beaten with a knife or fork and add it to the soup slowly and stir for 8 seconds\r\nServe the soup in a bowl and add the green onions on top.', 'https://www.themealdb.com/images/media/meals/1529446137.jpg', 'Soup,Baking,Calorific', '2025-12-04 06:15:01'),
(8, 53157, 'Chorizo & soft-boiled egg salad', 'Pork', 'Spanish', 'step 1\r\nCook the potatoes in a large pan of boiling salted water for 12 mins, adding the eggs after 6 mins, and the beans for the final 2 mins. Drain everything and cool the eggs under cold running water.\r\n\r\nstep 2\r\nMeanwhile fry chorizo slices for 1-2 mins, until beginning to crisp. Remove from the pan with a slotted spoon and set aside, leaving the oil from the chorizo in the pan. Add the garlic to the pan and cook gently for 1 min.\r\n\r\nstep 3\r\nRemove the pan from the heat, stir in the vinegar and parsley, then toss with the potatoes, beans, chorizo and seasoning. Shell the eggs, cut into quarters and add to the salad.', 'https://www.themealdb.com/images/media/meals/v8eaed1763257313.jpg', '', '2025-12-04 06:15:01'),
(9, 53074, 'Grilled eggplant with coconut milk', 'Vegetarian', 'Filipino', '.  Prepare the eggplants for grilling by pricking them all over with a fork.  This is so it won’t burst during the grilling process as the natural water in it heats up.\r\n2.  Grill the eggplants, turning them over frequently to ensure even cooking.  Grill until the skins are dark brown, even black and the eggplant is soft when you touch it.\r\n3.  Soak the grilled eggplant in a bowl of water to cool it down.  Peel the skin off the eggplant.  Place the whole eggplants in a shallow dish (my mom actually cuts the eggplant into small, bite-sized pieces).\r\n 4.  In a small mixing bowl, mix together the coconut milk or cream, lemon powder, salt and hot pepper.  Mix until the lemon powder and salt dissolve.  Taste, then adjust the amount of lemon powder, salt and hot pepper to your liking.  Pour the mixture over the eggplant.  Sprinkle the green onions over the eggplant and coconut milk.  Stir gently to combine. \r\n', 'https://www.themealdb.com/images/media/meals/bopa2i1683209167.jpg', '', '2025-12-04 06:15:01'),
(10, 52817, 'Stovetop Eggplant With Harissa, Chickpeas, and Cumin Yogurt', 'Vegetarian', 'American', 'Heat the oil in a 12-inch skillet over high heat until shimmering. Add the eggplants and lower the heat to medium. Season with salt and pepper as you rotate the eggplants, browning them on all sides. Continue to cook, turning regularly, until a fork inserted into the eggplant meets no resistance (you may have to stand them up on their fat end to finish cooking the thickest parts), about 20 minutes, lowering the heat and sprinkling water into the pan as necessary if the eggplants threaten to burn or smoke excessively.\r\n\r\n2.\r\nMix the harissa, chickpeas and tomatoes together, then add to the eggplants. Cook until the tomatoes have blistered and broken down, about 5 minutes more. Season with salt and pepper and add water as necessary to thin to a saucy consistency. Meanwhile, combine the yogurt and cumin in a serving bowl. Season with salt and pepper.\r\n\r\n3.\r\nTop the eggplant mixture with the parsley, drizzle with more extra virgin olive oil, and serve with the yogurt on the side.', 'https://www.themealdb.com/images/media/meals/yqwtvu1487426027.jpg', 'Vegetarian', '2025-12-04 06:15:01'),
(11, 52816, 'Roasted Eggplant With Tahini, Pine Nuts, and Lentils', 'Vegetarian', 'American', '\r\nFor the Lentils: Adjust oven rack to center position and preheat oven to 450°F to prepare for roasting eggplant. Meanwhile, heat 2 tablespoons olive oil in a medium saucepan over medium heat until shimmering. Add carrots, celery, and onion and cook, stirring, until softened but not browned, about 4 minutes. Add garlic and cook, stirring, until fragrant, about 30 seconds. Add lentils, bay leaves, stock or water, and a pinch of salt. Bring to a simmer, cover with the lid partially ajar, and cook until lentils are tender, about 30 minutes. (Top up with water if lentils are at any point not fully submerged.) Remove lid, stir in vinegar, and reduce until lentils are moist but not soupy. Season to taste with salt and pepper, cover, and keep warm until ready to serve.\r\n\r\n2.\r\nFor the Eggplant: While lentils cook, cut each eggplant in half. Score flesh with the tip of a paring knife in a cross-hatch pattern at 1-inch intervals. Transfer to a foil-lined rimmed baking sheet, cut side up, and brush each eggplant half with 1 tablespoon oil, letting each brushstroke be fully absorbed before brushing with more. Season with salt and pepper. Place a rosemary sprig on top of each one. Transfer to oven and roast until completely tender and well charred, 25 to 35 minutes. Remove from oven and discard rosemary.\r\n\r\n3.\r\nTo Serve: Heat 2 tablespoons olive oil and pine nuts in a medium skillet set over medium heat. Cook, tossing nuts frequently, until golden brown and aromatic, about 4 minutes. Transfer to a bowl to halt cooking. Stir half of parsley and rosemary into lentils and transfer to a serving platter. Arrange eggplant halves on top. Spread a few tablespoons of tahini sauce over each eggplant half and sprinkle with pine nuts. Sprinkle with remaining parsley and rosemary, drizzle with additional olive oil, and serve.', 'https://www.themealdb.com/images/media/meals/ysqrus1487425681.jpg', 'Vegetarian,Pulse,Nutty', '2025-12-04 06:15:02');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `meal_id` (`meal_id`),
  ADD UNIQUE KEY `meal_id_2` (`meal_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
