<?
// This file randomly emulates QuEST output or supplies a sample three-segment data response if no POST data is received

	$dummy_response = <<<SEE
id	source	moses_rank	moses	google_rank	google	lucy_rank	lucy
1	Keine befreiende Novelle für Tymoshenko durch das Parlament	1	no liberating amendment by Parliament for Tymoshenko	2	No amendment liberating for Tymoshenko by Parliament	3	No releasing novelette for Tymoshenko through the parliament
2	"Das ukrainische Parlament verweigerte heute den Antrag, im Rahmen einer Novelle des Strafgesetzbuches denjenigen Paragrafen abzuschaffen, auf dessen Grundlage die Oppositionsführerin Yulia Timoshenko verurteilt worden war."	3	"the Ukrainian Parliament refused the motion today, within the framework of a revision of the penal code of those paragraphs, on the basis of the opposition leader Yulia Timoshenko was condemned."	2	"The Ukrainian parliament today refused the request to abolish those paragraphs in an amendment to the Criminal Code, was convicted on the basis of the opposition leader Yulia Timoshenko."	1	"The Ukrainian parliament refused the request today, to abolish within the framework of a novelette of the penal code the Paragrafen on whose basis the opposition leader Yulia Timoshenko had been condemned."
3	"Die Neuregelung, die den Weg zur Befreiung der inhaftierten Expremierministerin hätte ebnen können, lehnten die Abgeordneten bei der zweiten Lesung des Antrags auf Milderung der Strafen für wirtschaftliche Delikte ab."	2	"the new regulation, which will pave the way for the release of the imprisoned Expremierministerin would make it possible, for the second reading of the proposal to reduce the penalties for economic crimes."	3	"The new regulations, which would have the path to liberation of the imprisoned Expremierministerin can pave the deputies rejected on the second reading of the application from on mitigating the penalties for economic crimes."	1	The representatives refused the new regulation which could have smoothed the way for the liberation of the arrested ex prime minister during the second reading of the request for easing of the punishments for economical offenses.
SEE;

	if ($_POST['data']) {
		echo("id	source	moses_rank	moses	google_rank	google	lucy_rank	lucy\n");
		$lines = explode("\n", $_POST['data']);
		foreach ($lines as $line) {
			if (!preg_match("#^id\tsource#", $line)) {

				$counter = rand(1,3);
				$line = preg_replace('#^(.+?\t.+?\t)(.+)$#', "\${1}".$counter."\t\\2", $line);

				if ($counter == 3) { $counter = 1; } else { $counter++; }
				$line = preg_replace("#(^.+?\t.+?\t.+?\t.+?\t)(.+)#", "\${1}".$counter."\t\\2", $line);

				if ($counter == 3) { $counter = 1; } else { $counter++; }
				$line = preg_replace("#(^.+?\t.+?\t.+?\t.+?\t.+?\t.+?\t)(.+)#", "\${1}".$counter."\t\\2", $line);

				if (preg_match("#[^\t\r\n]#", $line)) {
					echo(trim($line));
				}
			}
		}
	} else {
		echo("<tr><th colspan=\"8\">No data was received via the form. Showing dummy data instead.</th></tr>\n");
		echo($dummy_response);
	}
?>