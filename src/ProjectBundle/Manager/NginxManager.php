<?php
/**
 * NginxManager.php
 *
 * @since 07/04/17
 * @author gseidel
 */

namespace ProjectBundle\Manager;

use ProjectBundle\Entity\Host;

class NginxManager extends AbstractManager
{
    /**
     * @param Host[] $hosts
     * @return string
     */
    public function compileHosts($hosts)
    {
        $this->getLogger()->info('compile nginx file');

        $content = $this->render('ProjectBundle:Nginx:nginx.conf.twig', [
            'hosts' => $hosts
        ]);

        $configPath = $this->getConfigPath();
        $this->getFilesystem()->dumpFile($configPath, $content);

        $this->getLogger()->info(sprintf('config file saved to "%s"', $configPath));

        return $content;
    }

    /**
     * @return string
     */
    public function compile()
    {
        $hosts = $this->container->get('project.repository.host')->findAll();
        $content = $this->compileHosts($hosts);
        return $content;
    }

    public function restart()
    {
        $this->executeCommand('sudo service nginx restart');
    }

    public function reload()
    {
        $this->executeCommand('sudo service nginx reload');
    }

    private function getConfigPath()
    {
        return $this->container->getParameter('nginx_config');
    }
}