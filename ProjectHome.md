This project provides test applications with equivalent features. Its goal is to test the execution speed of various object model operations across major PHP ORMs.

Here is the result as of 09/2011:

```
                               | Insert | findPk | complex| hydrate|  with  |
                               |--------|--------|--------|--------|--------|
                  PDOTestSuite |    111 |    109 |     95 |    106 |     99 |
             Propel14TestSuite |   1260 |    502 |    123 |    311 |    303 |
             Propel15TestSuite |   1050 |    522 |    165 |    414 |    602 |
             Propel16TestSuite |    363 |    198 |    176 |    423 |    466 |
    Propel16WithCacheTestSuite |    292 |    146 |    148 |    351 |    345 |
           Doctrine12TestSuite |   2187 |   3425 |    545 |   2276 |   2365 |
  Doctrine12WithCacheTestSuite |   2508 |   1500 |    665 |   1481 |    933 |
            Doctrine2TestSuite |    151 |    709 |    160 |    800 |    488 |
```

The reference is the PDOTestSuite (the number of tests is adjusted to make raw PDO score about 100 to each test). For the ORMs, the smaller score is the better (i. e. the faster).