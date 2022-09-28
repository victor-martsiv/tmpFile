# tmpFile

### Simple lib for work with tmp file. 

## Example
```  
$filePath = 'some/file/path';
$tmpHandler = new \KnightWithKnife\Tmp\File($filePath);
$tmpHandler->write($testData);
$tmpHandler->append($testData);
$data = $tmpHandler->read();
$data = $tmpHandler->lazyRead();
$tmpHandler->delete();
```