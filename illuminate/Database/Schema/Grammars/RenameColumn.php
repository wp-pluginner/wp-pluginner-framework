<?php

namespace WpPluginner\Illuminate\Database\Schema\Grammars;

use WpPluginner\Illuminate\Support\Fluent;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\TableDiff;
use WpPluginner\Illuminate\Database\Connection;
use WpPluginner\Illuminate\Database\Schema\Blueprint;
use Doctrine\DBAL\Schema\AbstractSchemaManager as SchemaManager;

class RenameColumn
{
    /**
     * Compile a rename column command.
     *
     * @param  \WpPluginner\Illuminate\Database\Schema\Grammars\Grammar  $grammar
     * @param  \WpPluginner\Illuminate\Database\Schema\Blueprint  $blueprint
     * @param  \WpPluginner\Illuminate\Support\Fluent  $command
     * @param  \WpPluginner\Illuminate\Database\Connection  $connection
     * @return array
     */
    public static function compile(Grammar $grammar, Blueprint $blueprint, Fluent $command, Connection $connection)
    {
        $column = $connection->getDoctrineColumn(
            $grammar->getTablePrefix().$blueprint->getTable(), $command->from
        );

        $schema = $connection->getDoctrineSchemaManager();

        return (array) $schema->getDatabasePlatform()->getAlterTableSQL(static::getRenamedDiff(
            $grammar, $blueprint, $command, $column, $schema
        ));
    }

    /**
     * Get a new column instance with the new column name.
     *
     * @param  \WpPluginner\Illuminate\Database\Schema\Grammars\Grammar  $grammar
     * @param  \WpPluginner\Illuminate\Database\Schema\Blueprint  $blueprint
     * @param  \WpPluginner\Illuminate\Support\Fluent  $command
     * @param  \Doctrine\DBAL\Schema\Column  $column
     * @param  \Doctrine\DBAL\Schema\AbstractSchemaManager  $schema
     * @return \Doctrine\DBAL\Schema\TableDiff
     */
    protected static function getRenamedDiff(Grammar $grammar, Blueprint $blueprint, Fluent $command, Column $column, SchemaManager $schema)
    {
        return static::setRenamedColumns(
            $grammar->getDoctrineTableDiff($blueprint, $schema), $command, $column
        );
    }

    /**
     * Set the renamed columns on the table diff.
     *
     * @param  \Doctrine\DBAL\Schema\TableDiff  $tableDiff
     * @param  \WpPluginner\Illuminate\Support\Fluent  $command
     * @param  \Doctrine\DBAL\Schema\Column  $column
     * @return \Doctrine\DBAL\Schema\TableDiff
     */
    protected static function setRenamedColumns(TableDiff $tableDiff, Fluent $command, Column $column)
    {
        $tableDiff->renamedColumns = [
            $command->from => new Column($command->to, $column->getType(), $column->toArray()),
        ];

        return $tableDiff;
    }
}
