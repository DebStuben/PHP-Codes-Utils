<?php

/*

	Code permetant de générer la liste des catégories et sous catégories dont la profondeur n'est pas connu
	Ce code fonctionne grace à une fonction récursive

	Dans le principe les données sont stocké dans une table de bdd sous la forme suivant :

	Id 			: Identifiant de la catégorie
	Parent 		: Contient l'identifiant du parent ou 0 si catégorie principale
	Name 		: Nom de la catégorie

	Exemple de contenue dans la base de données

	Id 		Parent 		Name
	---------------------------------
	1		0			Developpement
	2		1			compilé
	3 		1			interpreté
	4 		2			C
	5 		4			C++
	6 		3 			Web
	7		6 			Php
	8 		6			Javascript
	9		6			hml5
	10		3 			Python
	11		2			Java


	Exemple de récupération MySQL

	$query = "SELECT Id, Parent, Name FROM Categories ORDER BY Name";
	$result = mysql_query($query);
 
	$categories = array();
 
	while($row = mysql_fetch_array($result)) {
		$categories[] = array(
			'parent_id' => $row['Parent'],
			'categorie_id' => $row['Id'],
			'nom_categorie' => $row['Name']
		);
	}						

*/
	// Tableau normalement résultant de la requete sql
	$categories = array(
		0 => array(
			'parent_id' => 0,
            'categorie_id' => 1,
            'nom_categorie' => "Developpement"
			),
		1 => array(
			'parent_id' => 1,
            'categorie_id' => 2,
            'nom_categorie' => "compilé"
			),
		2 => array(
			'parent_id' => 1,
            'categorie_id' => 3,
            'nom_categorie' => "interpreté"
			),
		3 => array(
			'parent_id' => 2,
            'categorie_id' => 4,
            'nom_categorie' => "C"
			),
		4 => array(
			'parent_id' => 4,
            'categorie_id' => 5,
            'nom_categorie' => "C++"
			),
		5 => array(
			'parent_id' => 3,
            'categorie_id' => 6,
            'nom_categorie' => "Web"
			),
		6 => array(
			'parent_id' => 6,
            'categorie_id' => 7,
            'nom_categorie' => "Php"
			),
		7 => array(
			'parent_id' => 6,
            'categorie_id' => 8,
            'nom_categorie' => "Javascript"
			),
		8 => array(
			'parent_id' => 6,
            'categorie_id' => 9,
            'nom_categorie' => "html5"
			),
		9 => array(
			'parent_id' => 3,
            'categorie_id' => 10,
            'nom_categorie' => "Python"
			),
		10 => array(
			'parent_id' => 2,
            'categorie_id' => 11,
            'nom_categorie' => "Java"
			)
		);



	function afficher_menu($parent, $niveau, $array) {
		$html = "";
		$niveau_precedent = 0;
 
		if (!$niveau && !$niveau_precedent) $html .= "\n<ul>\n";
 
		foreach ($array as $noeud) {
			if ($parent == $noeud['parent_id']) {
				if ($niveau_precedent < $niveau) $html .= "\n<ul>\n";
				$html .= "<li>" . $noeud['nom_categorie'];	
				$niveau_precedent = $niveau;
				$html .= afficher_menu($noeud['categorie_id'], ($niveau + 1), $array);
			}
		}
 		if (($niveau_precedent == $niveau) && ($niveau_precedent != 0)) $html .= "</ul>\n</li>\n";
		else if ($niveau_precedent == $niveau) $html .= "</ul>\n";
		else $html .= "</li>\n";

		return $html;
	}

	echo afficher_menu(0,0,$categories);


/* Résultat obtenu

<ul>
	<li>Developpement
		<ul>
			<li>compilÃ©
				<ul>
					<li>C
						<ul>
							<li>C++</li>
						</ul>
					</li>
					<li>Java</li>
				</ul>
			</li>
			<li>interpretÃ©
				<ul>
					<li>Web
						<ul>
							<li>Php</li>
							<li>Javascript</li>
							<li>html5</li>
						</ul>
					</li>
					<li>Python</li>
				</ul>
			</li>
		</ul>
	</li>
</ul>

*/


?>