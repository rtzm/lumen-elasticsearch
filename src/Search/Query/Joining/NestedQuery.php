<?php namespace Nord\Lumen\Elasticsearch\Search\Query\Joining;

use Nord\Lumen\Elasticsearch\Search\Query\QueryDSL;

/**
 * Nested query allows to query nested objects / docs (see nested mapping).
 *
 * The query is executed against the nested objects / docs as if they were indexed as separate docs (they are,
 * internally) and resulting in the root parent doc (or parent nested mapping).
 *
 * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-nested-query.html
 */
class NestedQuery extends AbstractQuery
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var QueryDSL
     */
    private $query;


    /**
     * @inheritdoc
     */
    public function toArray()
    {
        $nested = [
            'path'  => $this->getPath(),
            'query' => $this->getQuery()->toArray(),
        ];

        $scoreMode = $this->getScoreMode();
        if (!is_null($scoreMode)) {
            $nested['score_mode'] = $scoreMode;
        }

        return ['nested' => $nested];
    }

    /**
     * @inheritdoc
     */
    protected function getValidScoreModes()
    {
        return [
            self::SCORE_MODE_AVG,
            self::SCORE_MODE_SUM,
            self::SCORE_MODE_MIN,
            self::SCORE_MODE_MAX,
            self::SCORE_MODE_NONE,
        ];
    }


    /**
     * @param string $path
     * @return NestedQuery
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }


    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }


    /**
     * @param QueryDSL $query
     * @return NestedQuery
     */
    public function setQuery(QueryDSL $query)
    {
        $this->query = $query;
        return $this;
    }


    /**
     * @return QueryDSL
     */
    public function getQuery()
    {
        return $this->query;
    }
}
