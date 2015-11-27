<?php

namespace RedDevil\ORM;

class EntityManager {
    public static function create()
    {
        $repositoryNames =  self::getRepositoryNames();
        $privateRepositoryFields = "";
        foreach ($repositoryNames as $name) {
            $privateRepositoryFields .= "\tprivate $" . $name . ";\n";
        }
        $privateRepositoryFields = ltrim($privateRepositoryFields, "\t");
        $privateRepositoryFields = rtrim($privateRepositoryFields, "\n");

        $docConstructorParameters = '';


        $constructorParametersList = '';

        $settingPrivateRepositoryFields = '';
        foreach ($repositoryNames as $name) {
            $repoClassName = ucfirst($name);
            $settingPrivateRepositoryFields .= "\t\t\$this->$name = \RedDevil\Repositories\\$repoClassName::create();\n";
        }
        $settingPrivateRepositoryFields = ltrim($settingPrivateRepositoryFields, "\t");
        $settingPrivateRepositoryFields = rtrim($settingPrivateRepositoryFields, "\n");

        $addRepositoriesToInternalCollection = '';
        foreach ($repositoryNames as $name) {
            $addRepositoriesToInternalCollection .= "\t\t\$this->repositories[] = \$this->$name;\n";
        }
        $addRepositoriesToInternalCollection = ltrim($addRepositoriesToInternalCollection, "\t");
        $addRepositoriesToInternalCollection = rtrim($addRepositoriesToInternalCollection, "\n");

        $repositoryGetters = '';
        foreach ($repositoryNames as $name) {
            $repoName = ucfirst($name);
            $repositoryGetters .= <<<KUF
    /**
     * @return \RedDevil\Repositories\\$repoName
     */
    public function get$repoName()
    {
        return \$this->$name;
    }
KUF;
            $repositoryGetters .= "\n\n";
        }
        $repositoryGetters = ltrim($repositoryGetters, "\t");
        $repositoryGetters = rtrim($repositoryGetters, "\n");

        $repositorySetters = '';
        foreach ($repositoryNames as $name) {
            $repoName = ucfirst($name);
            $repositorySetters .= <<<KUF
    /**
     * @param mixed $$name
     * @return \$this
     */
    public function set$repoName($$name)
    {
        \$this->$name = $$name;
        return \$this;
    }
KUF;
            $repositorySetters .= "\n\n";
        }
        $repositorySetters = ltrim($repositorySetters, "\t");
        $repositorySetters = rtrim($repositorySetters, "\n");

        // Here starts the DatabaseContextFileCreation:
        $contents = file_get_contents('EntityManager' .
            DIRECTORY_SEPARATOR . 'Templates' . DIRECTORY_SEPARATOR .
            'DatabaseContextTemplate.txt');

        $contents = str_replace("{{privateRepositoryFields}}", $privateRepositoryFields, $contents);
        $contents = str_replace("{{docConstructorParameters}}", $docConstructorParameters, $contents);
        $contents = str_replace("{{constructorParametersList}}", $constructorParametersList, $contents);
        $contents = str_replace("{{settingPrivateRepositoryFields}}", $settingPrivateRepositoryFields, $contents);
        $contents = str_replace("{{addRepositoriesToInternalCollection}}", $addRepositoriesToInternalCollection, $contents);
        $contents = str_replace("{{repositoryGetters}}", $repositoryGetters, $contents);
        $contents = str_replace("{{repositorySetters}}", $repositorySetters, $contents);

        $databaseContextFile = fopen(
            'EntityManager' . DIRECTORY_SEPARATOR .
            'DatabaseContext.php'
            , 'w');
        fwrite($databaseContextFile, $contents);
    }

    public static function getRepositoryNames()
    {
        $names = [];

        $dirHandle = opendir('Repositories');
        $file = readdir($dirHandle);

        while ($file) {
            if ($file[0] == '.') {
                $file = readdir($dirHandle);
                continue;
            }

            $names[] = lcfirst(substr($file, 0, strlen($file) - 4));
            $file = readdir($dirHandle);
        }

        return $names;
    }
}