<?php
/**
 * Created by JetBrains PhpStorm.
 * User: nezuvian
 * Date: 2013.05.31.
 * Time: 22:57
 * To change this template use File | Settings | File Templates.
 */

namespace VAK\StarsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DBCommand extends ContainerAwareCommand {
    protected function configure() {
        $this
            ->setName('vakstars:db_merge')
            ->setDescription('vakstars db merge');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {
        $db = new \PDO('mysql:host=localhost;dbname=vakstars;charset=utf8', 'root', '');
        $stmt = $db->query('SELECT * FROM votes');
        $votes = $stmt->fetchAll();

        foreach($votes as $vote) {
            $voted_user = $vote['receiver'];
            $voter_user = $vote['sender'];
            $reason = $vote['reason'];
            $date = $vote['date'];

            $query = "INSERT INTO vote (voted_user_id, voter_user_id, created_at, comment, type)
            VALUES ('".$voted_user."', '".$voter_user."', '".$date."', '".$reason."', 1)";
            $db->exec($query);
            $output->writeln($query);
        }
    }
}