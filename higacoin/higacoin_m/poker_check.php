<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./stylesheet.css">
  <title>Poker Sample</title>
</head>

<body>
  <?php
  session_start();
  error_reporting(0);
  // 未ログインを弾く
  if ($_SESSION['LOGIN'] == null) {
    header('Location: ./signup.php');
  }
  if ($_SESSION['LOGIN'] == 1) {
    header('Location: ./signup.php');
  }
  if ($_SESSION['READY'] == 2) {
    $numbers = $_SESSION['NUMBER'];
    $pairs = $_SESSION['PAIRS'];
    $pairs2 = $_SESSION['PAIRS2'];
    $n1 = $pairs[0] + 3;
    $n2 = $pairs[1] + 3;
    $n3 = $pairs[2] + 3;
    $num_m = $numbers[0];
    $num0_m = $numbers[1];
    $num1_m = $numbers[$n1];
    $num2_m = $numbers[$n2];
    $num3_m = $numbers[$n3];
    $num_md[] = $num_m % 4;
    $num_md[] = $num0_m % 4;
    $num_md[] = $num1_m % 4;
    $num_md[] = $num2_m % 4;
    $num_md[] = $num3_m % 4;
    $num_n = $numbers[0];
    $num0_n = $numbers[1];
    $num1_n = $numbers[$n1];
    $num2_n = $numbers[$n2];
    $num3_n = $numbers[$n3];
    $num_n = ($num_n - 1) / 4 + 1;
    $num0_n = ($num0_n - 1) / 4 + 1;
    $num1_n = ($num1_n - 1) / 4 + 1;
    $num2_n = ($num2_n - 1) / 4 + 1;
    $num3_n = ($num3_n - 1) / 4 + 1;
    $num[] = floor($num_n);
    $num[] = floor($num0_n);
    $num[] = floor($num1_n);
    $num[] = floor($num2_n);
    $num[] = floor($num3_n);
    $n21 = $pairs2[0] + 3;
    $n22 = $pairs2[1] + 3;
    $n23 = $pairs2[2] + 3;
    $n2um_m = $numbers[2];
    $n2um0_m = $umbers[3];
    $n2um1_m = $umbers[$n21];
    $n2um2_m = $umbers[$n22];
    $num3_m = $numbers[$n23];
    $num2_md2[] = $n2um_m % 4;
    $num2_md2[] = $n2um0_m % 4;
    $num2_md2[] = $n2um1_m % 4;
    $num2_md2[] = $n2um2_m % 4;
    $num2_md2[] = $n2um3_m % 4;
    $n2um_n = $numbers[2];
    $n2um0_n = $numbers[3];
    $n2um1_n = $numbers[$n21];
    $n2um2_n = $numbers[$n22];
    $n2um3_n = $numbers[$n23];
    $n2um_n = ($n2um_n - 1) / 4 + 1;
    $n2um0_n = ($n2um0_n - 1) / 4 + 1;
    $n2um1_n = ($n2um1_n - 1) / 4 + 1;
    $n2um2_n = ($n2um2_n - 1) / 4 + 1;
    $n2um3_n = ($n2um3_n - 1) / 4 + 1;
    $num2[] = floor($n2um_n);
    $num2[] = floor($n2um0_n);
    $num2[] = floor($n2um1_n);
    $num2[] = floor($n2um2_n);
    $num2[] = floor($n2um3_n);
    $count_n = 0;
    sort($num);
    sort($num2);
    for ($i = 1; $i < 5; $i++) {
      if ($num_md[0] != $num_md[$i]) {
        $different = 1;
      }
    }
    for ($n = 1; $n <= 5; $n++) {
      if ($num[$n - 1] + 1 == $num[$n]) {
        $same++;
      }
    }
    if ($num[0] == 1 && $num[4] == 13) {
      $same++;
      $check = 1;
    }
    for ($m = 1; $m < 5; $m++) {
      $m2 = $m;
      $m3 = $m - 1;
      $m4 = $m - 1;
      if ($m2 == 1) {
        $m2--;
      }
      if ($m3 >= 2) {
        $m3++;
      }
      if ($m4 >= 3) {
        $m4++;
      }
      if ($num[0] == $num[$m]) {
        $same_n++;
      }
      if ($num[1] == $num[$m2]) {
        $same_n2++;
      }
      if ($num[2] == $num[$m3]) {
        $same_n3++;
      }
      if ($num[3] == $num[$m4]) {
        $same_n4++;
      }
    }
    if ($different >= 1) {
      if ($same == 4) {
        if ($num[0] == 1 && $num[1] == 2 && $check == 1) {
          $strength = 1;
          $checker = 1;
          echo '<p class="message">ハイカード</p>';
        } else {
          $strength = 5;
          echo '<p class="message">ストレート</p>';
        }
      } else {
        if ($same_n == 3 || $same_n2 == 3 || $same_n3 == 3 || $same_n4 == 3) {
          $strength = 8;
          echo '<p class="message">フォーカード</p>';
        } elseif ($same_n == 2 || $same_n2 == 2 || $same_n3 == 2 || $same_n4 == 2) {
          if ($same_n + $same_n2 + $same_n3 + $same_n4 == 6) {
            if ($same_n == 1 && $same_n2 == 1) {
              $count_n++;
              $strength = 7;
              echo '<p class="message">フルハウス</p>';
            }
          }
          if ($same_n + $same_n2 + $same_n3 + $same_n4 == 7) {
            $strength = 7;
            echo '<p class="message">フルハウス</p>';
          } else {
            if ($count_n == 0) {
              $strength = 4;
              echo '<p class="message">スリーカード</p>';
            }
          }
        } elseif ($same_n == 1 || $same_n2 == 1 || $same_n3 == 1 || $same_n4 == 1) {
          if ($same_n + $same_n2 + $same_n3 + $same_n4 == 4 || $same_n + $same_n2 + $same_n3 + $same_n4 == 3) {
            $strength = 3;
            echo '<p class="message">ツーペア</p>';
          } else {
            $strength = 2;
            echo '<p class="message">ワンペア</p>';
          }
        } else {
          $strength = 1;
          echo '<p class="message">ハイカード</p>';
        }
      }
    } else {
      if ($same == 4 && $checker != 1) {
        if ($num[0] == 1 && $num[1] == 10 && $same == 4) {
          $strength = 10;
          echo '<p class="message">ロイヤルストレートフラッシュ</p>';
        } else {
          $strength = 9;
          echo '<p class="message">ストレートフラッシュ</p>';
        }
      } else {
        if ($same_n == 3 || $same_n2 == 3 || $same_n3 == 3 || $same_n4 == 3) {
          $strength = 8;
          echo '<p class="message">フォーカード</p>';
        } elseif ($same_n + $same_n2 + $same_n3 + $same_n4 == 7) {
          $strength = 7;
          echo '<p class="message">フルハウス</p>';
        } elseif ($same_n + $same_n2 + $same_n3 + $same_n4 == 6) {
          if ($same_n == 1 && $same_n2 == 1) {
            $strength = 7;
            echo '<p class="message">フルハウス</p>';
          } else {
            $strength = 6;
            echo '<p class="message">フラッシュ</p>';
          }
        } else {
          $strength = 6;
          echo '<p class="message">フラッシュ</p>';
        }
      }
    }
    $count_n2 = 0;
    for ($i2 = 1; $i2 < 5; $i2++) {
      if ($num2_md2[0] != $num2_md2[$i2]) {
        $different2 = 1;
      }
    }
    for ($n2 = 1; $n2 <= 5; $n2++) {
      if ($num2[$n2 - 1] + 1 == $num2[$n2]) {
        $same2++;
      }
    }
    if ($num2[0] == 1 && $num2[4] == 13) {
      $same2++;
      $check2 = 1;
    }
    for ($m2 = 1; $m2 < 5; $m2++) {
      $m22 = $m2;
      $m23 = $m2 - 1;
      $m24 = $m2 - 1;
      if ($m22 == 1) {
        $m22--;
      }
      if ($m23 >= 2) {
        $m23++;
      }
      if ($m24 >= 3) {
        $m24++;
      }
      if ($num2[0] == $num2[$m2]) {
        $same2_n++;
      }
      if ($num2[1] == $num2[$m22]) {
        $same2_n2++;
      }
      if ($num2[2] == $num2[$m23]) {
        $same2_n3++;
      }
      if ($num2[3] == $num2[$m24]) {
        $same2_n4++;
      }
    }
    if ($different2 >= 1) {
      if ($same2 == 4) {
        if ($num2[0] == 1 && $num2[1] == 2 && $check2 == 1) {
          $strength2 = 1;
          $checker2 = 1;
          echo '<p class="message">ハイカード</p>';
        } else {
          $strength2 = 5;
          echo '<p class="message">ストレート</p>';
        }
      } else {
        if ($same2_n == 3 || $same2_n2 == 3 || $same2_n3 == 3 || $same2_n4 == 3) {
          $strength2 = 8;
          echo '<p class="message">フォーカード</p>';
        } elseif ($same2_n == 2 || $same2_n2 == 2 || $same2_n3 == 2 || $same2_n4 == 2) {
          if ($same2_n + $same2_n2 + $same2_n3 + $same2_n4 == 6) {
            if ($same2_n == 1 && $same2_n2 == 1) {
              $count_n2++;
              $strength2 = 7;
              echo '<p class="message">フルハウス</p>';
            }
          }
          if ($same2_n + $same2_n2 + $same2_n3 + $same2_n4 == 7) {
            $strength2 = 7;
            echo '<p class="message">フルハウス</p>';
          } else {
            if ($count_n2 == 0) {
              $strength2 = 4;
              echo '<p class="message">スリーカード</p>';
            }
          }
        } elseif ($same2_n == 1 || $same2_n2 == 1 || $same2_n3 == 1 || $same2_n4 == 1) {
          if ($same2_n + $same2_n2 + $same2_n3 + $same2_n4 == 4 || $same2_n + $same2_n2 + $same2_n3 + $same2_n4 == 3) {
            $strength2 = 3;
            echo '<p class="message">ツーペア</p>';
          } else {
            $strength2 = 2;
            echo '<p class="message">ワンペア</p>';
          }
        } else {
          $strength2 = 1;
          echo '<p class="message">ハイカード</p>';
        }
      }
    } else {
      if ($same2 == 4) {
        if ($num2[0] == 1 && $num2[1] == 10 && $same2 == 4 && $checker2 != 1) {
          $strength2 = 10;
          echo '<p class="message">ロイヤルストレートフラッシュ</p>';
        } else {
          $strength2 = 9;
          echo '<p class="message">ストレートフラッシュ</p>';
        }
      } else {
        if ($same2_n == 3 || $same2_n2 == 3 || $same2_n3 == 3 || $same2_n4 == 3) {
          $strength2 = 8;
          echo '<p class="message">フォーカード</p>';
        } elseif ($same2_n + $same2_n2 + $same2_n3 + $same2_n4 == 7) {
          $strength2 = 7;
          echo '<p class="message">フルハウス</p>';
        } elseif ($same2_n + $same2_n2 + $same2_n3 + $same2_n4 == 6) {
          if ($same2_n == 1 && $same2_n2 == 1) {
            $strength2 = 7;
            echo '<p class="message">フルハウス</p>';
          } else {
            $strength2 = 6;
            echo '<p class="message">フラッシュ</p>';
          }
        } else {
          $strength2 = 6;
          echo '<p class="message">フラッシュ</p>';
        }
      }
    }
    $win = null;
    $win2 = null;
    $match = null;
    if ($strength > $strength2) {
      echo '<h1 class="win_message">' . $_SESSION['NAME'] . 'の勝利</h1>';
      $_SESSION['WIN'] = 1;
    } elseif ($strength < $strength2) {
      echo '<h1 class="win_message">' . $_SESSION['NAME_2'] . 'の勝利</h1>';
      $_SESSION['WIN'] = 2;
    } else {
      if ($strength == 1 && $strength2 == 1) {
        $match = 1;
      }
      if ($strength == 5 && $strength2 == 5) {
        $match = 1;
      }
      if ($strength == 6 && $strength2 == 6) {
        $match = 1;
      }
      if ($strength == 9 && $strength2 == 9) {
        $match = 1;
      }
      if ($strength == 8 && $strength2 == 8) {
        $match = 2;
      }
      if ($strength == 7 && $strength2 == 7) {
        $match = 3;
      }
      if ($strength == 4 && $strength2 == 4) {
        $match = 4;
      }
      if ($strength == 3 && $strength2 == 3) {
        $match = 5;
      }
      if ($strength == 2 && $strength2 == 2) {
        $match = 6;
      }
      if ($match == 1) {
        if ($num[0] == 1) {
          $win = 1;
        }
        if ($num2[0] == 1) {
          $win2 = 1;
        }
        if ($win == 1 && $win == $win2) {
          echo '<h1 class="win_message">同点</h1>';
          $_SESSION['WIN'] = 3;
        } elseif ($win == null && $win2 == null) {
          if ($num[4] > $num2[4]) {
            echo '<h1 class="win_message">' . $_SESSION['NAME'] . 'の勝利</h1>';
            $_SESSION['WIN'] = 1;
          } elseif ($num[4] < $num2[4]) {
            echo '<h1 class="win_message">' . $_SESSION['NAME_2'] . 'の勝利</h1>';
            $_SESSION['WIN'] = 2;
          } else {
            echo '<h1 class="win_message">同点</h1>';
            $_SESSION['WIN'] = 3;
          }
        } else {
          if ($win == 1) {
            echo '<h1 class="win_message">' . $_SESSION['NAME'] . 'の勝利</h1>';
            $_SESSION['WIN'] = 1;
          } elseif ($win2 == 1) {
            echo '<h1 class="win_message">' . $_SESSION['NAME_2'] . 'の勝利</h1>';
            $_SESSION['WIN'] = 2;
          }
        }
      } elseif ($match == 2 || $match == 3) {
        if ($same_n == 3 || $same_n == 2) {
          if ($num[0] == 1) {
            $compare = $num[0] + 13;
          } else {
            $compare = $num[0];
          }
        } else {
          $compare = $num[2];
        }
        if ($same2_n == 3 || $same2_n == 2) {
          if ($num2[0] == 1) {
            $compare2 = $num2[0] + 13;
          } else {
            $compare2 = $num2[0];
          }
        } else {
          $compare2 = $num2[2];
        }
        if ($compare > $compare2) {
          echo '<h1 class="win_message">' . $_SESSION['NAME'] . 'の勝利</h1>';
          $_SESSION['WIN'] = 1;
        } elseif ($compare < $compare2) {
          echo '<h1 class="win_message">' . $_SESSION['NAME_2'] . 'の勝利</h1>';
          $_SESSION['WIN'] = 2;
        } else {
          if ($match == 2) {
            echo '<h1 class="win_message">同点</h1>';
            $_SESSION['WIN'] = 3;
          }
          if ($match == 3) {
            if ($same_n == 1) {
              if ($num[0] == 1) {
                $compare = $num[0] + 13;
              } else {
                $compare = $num[0];
              }
            } else {
              $compare = $num[3];
            }
            if ($same2_n == 1) {
              if ($num2[0] == 1) {
                $compare2 = $num2[0] + 13;
              } else {
                $compare2 = $num2[0];
              }
            } else {
              $compare2 = $num2[3];
            }
            if ($compare > $compare2) {
              echo '<h1 class="win_message">' . $_SESSION['NAME'] . 'の勝利</h1>';
              $_SESSION['WIN'] = 1;
            } elseif ($compare < $compare2) {
              echo '<h1 class="win_message">' . $_SESSION['NAME_2'] . 'の勝利</h1>';
              $_SESSION['WIN'] = 2;
            } else {
              echo '<h1 class="win_message">同点</h1>';
              $_SESSION['WIN'] = 3;
            }
          }
        }
      } elseif ($match == 4) {
        $compare = $num[2];
        $compare2 = $num2[2];
        if ($compare == 1) {
          $compare += 13;
        }
        if ($compare2 == 1) {
          $compare2 += 13;
        }
        if ($compare > $compare2) {
          echo '<h1 class="win_message">' . $_SESSION['NAME'] . 'の勝利</h1>';
          $_SESSION['WIN'] = 1;
        } elseif ($compare < $compare2) {
          echo '<h1 class="win_message">' . $_SESSION['NAME_2'] . 'の勝利</h1>';
          $_SESSION['WIN'] = 2;
        } else {
          if ($same_n != 2) {
            if ($num[0] == 1) {
              $compare = $num[0] + 13;
            }
          } else {
            $compare = $num[3];
          }
          if ($same2_n != 2) {
            if ($num2[0] == 1) {
              $compare2 = $num2[0] + 13;
            } else {
              $compare2 = $num2[0];
            }
          } else {
            $compare2 = $num2[3];
          }
          if ($num[0] != 1 && $same_n2 == 2) {
            $compare = $num[4];
          } else {
            if ($num[0] != 1) {
              $compare = $num[1];
            }
          }
          if ($num2[0] != 1 && $same2_n2 == 2) {
            $compare2 = $num2[4];
          } else {
            if ($num2[0] != 1) {
              $compare2 = $num2[1];
            }
          }
          if ($compare > $compare2) {
            echo '<h1 class="win_message">' . $_SESSION['NAME'] . 'の勝利</h1>';
            $_SESSION['WIN'] = 1;
          } elseif ($compare < $compare2) {
            echo '<h1 class="win_message">' . $_SESSION['NAME_2'] . 'の勝利</h1>';
            $_SESSION['WIN'] = 2;
          } else {
            echo '<h1 class="win_message">同点</h1>';
            $_SESSION['WIN'] = 3;
          }
        }
      } elseif ($match == 5) {
        $compare = $num[1];
        $compare2 = $num2[1];
        if ($compare != 1) {
          $compare = $num[3];
        } else {
          $compare += 13;
        }
        if ($compare2 != 1) {
          $compare2 = $num2[3];
        } else {
          $compare2 += 13;
        }
        if ($compare > $compare2) {
          echo '<h1 class="win_message">' . $_SESSION['NAME'] . 'の勝利</h1>';
          $_SESSION['WIN'] = 1;
        } elseif ($compare < $compare2) {
          echo '<h1 class="win_message">' . $_SESSION['NAME_2'] . 'の勝利</h1>';
          $_SESSION['WIN'] = 2;
        } else {
          if ($compare == 14) {
            $compare = $num[3];
          } else {
            $compare = $num[1];
          }
          if ($compare2 == 14) {
            $compare2 = $num2[3];
          } else {
            $compare2 = $num2[1];
          }
          if ($compare > $compare2) {
            echo '<h1 class="win_message">' . $_SESSION['NAME'] . 'の勝利</h1>';
            $_SESSION['WIN'] = 1;
          } elseif ($compare < $compare2) {
            echo '<h1 class="win_message">' . $_SESSION['NAME_2'] . 'の勝利</h1>';
            $_SESSION['WIN'] = 2;
          } else {
            if ($same_n != 1) {
              $compare = $num[0];
              if ($compare == 1) {
                $compare += 13;
              }
            } elseif ($same_n3 != 1) {
              $compare = $num[2];
            } else {
              $compare = $num[4];
            }
            if ($same2_n != 1) {
              $compare2 = $num2[0];
              if ($compare2 == 1) {
                $compare2 += 13;
              }
            } elseif ($same2_n3 != 1) {
              $compare2 = $num2[2];
            } else {
              $compare2 = $num2[4];
            }
            if ($compare > $compare2) {
              echo '<h1 class="win_message">' . $_SESSION['NAME'] . 'の勝利</h1>';
              $_SESSION['WIN'] = 1;
            } elseif ($compare < $compare2) {
              echo '<h1 class="win_message">' . $_SESSION['NAME_2'] . 'の勝利</h1>';
              $_SESSION['WIN'] = 2;
            } else {
              echo '<h1 class="win_message">同点</h1>';
              $_SESSION['WIN'] = 3;
            }
          }
        }
      } elseif ($match == 6) {
        if ($same_n != 1 && $same_n4 != 1) {
          $compare = $num[1];
        } elseif ($same_n3 != 1 && $same_n4 != 1) {
          $compare = $num[0];
          if ($compare == 1) {
            $compare += 13;
          }
        } elseif ($same_n != 1 && $same_n2 != 1 && $same_n3 == 1) {
          $compare = $num[3];
        } else {
          $compare = $num[4];
        }
        if ($same2_n != 1 && $same2_n4 != 1) {
          $compare2 = $num2[1];
        } elseif ($same2_n3 != 1 && $same2_n4 != 1) {
          $compare2 = $num2[0];
          if ($compare2 == 1) {
            $compare2 += 13;
          }
        } elseif ($same2_n != 1 && $same2_n2 != 1 && $same2_n3 == 1) {
          $compare2 = $num2[3];
        } else {
          $compare2 = $num2[4];
        }
        if ($compare > $compare2) {
          echo '<h1 class="win_message">' . $_SESSION['NAME'] . 'の勝利</h1>';
          $_SESSION['WIN'] = 1;
        } elseif ($compare < $compare2) {
          echo '<h1 class="win_message">' . $_SESSION['NAME_2'] . 'の勝利</h1>';
          $_SESSION['WIN'] = 2;
        } else {
          if ($same_n != 1 && $num[0] == 1) {
            $compare == $num[0] + 13;
          } else {
            if ($same_n != 1 && $num[0] == 1) {
              $compare = $num[0] + 13;
            } else {
              if ($same_n4 != 1) {
                $compare = $num[4];
              } elseif ($same_n3 == 1 && $same_n4 == 1) {
                $compare = $num[4];
              } else {
                $compare = $num[2];
              }
            }
          }
          if ($same2_n != 1 && $num2[0] == 1) {
            $compare2 == $num2[0] + 13;
          } else {
            if ($same2_n != 1 && $num2[0] == 1) {
              $compare2 = $num2[0] + 13;
            } else {
              if ($same2_n4 != 1) {
                $compare2 = $num2[4];
              } elseif ($same2_n3 == 1 && $same2_n4 == 1) {
                $compare2 = $num2[4];
              } else {
                $compare2 = $num2[2];
              }
            }
          }
          if ($compare > $compare2) {
            echo '<h1 class="win_message">' . $_SESSION['NAME'] . 'の勝利</h1>';
            $_SESSION['WIN'] = 1;
          } elseif ($compare < $compare2) {
            echo '<h1 class="win_message">' . $_SESSION['NAME_2'] . 'の勝利</h1>';
            $_SESSION['WIN'] = 2;
          } else {
            if ($compare == $num[4]) {
              if ($same_n3 == 1 && $same_n4 == 1) {
                $compare = $num[1];
              } else {
                $compare = $num[2];
              }
            } else {
              $compare = $num[1];
            }
            if ($compare2 == $num2[4]) {
              if ($same2_n3 == 1 && $same2_n4 == 1) {
                $compare2 = $num2[1];
              } else {
                $compare2 = $num2[2];
              }
            } else {
              $compare2 = $num2[1];
            }
            if ($compare > $compare2) {
              echo '<h1 class="win_message">' . $_SESSION['NAME'] . 'の勝利</h1>';
              $_SESSION['WIN'] = 1;
            } elseif ($compare < $compare2) {
              echo '<h1 class="win_message">' . $_SESSION['NAME_2'] . 'の勝利</h1>';
              $_SESSION['WIN'] = 2;
            } else {
              if ($same_n != 1) {
                $compare = $num[0];
              }
              if ($same2_n != 1) {
                $compare2 = $num2[0];
              }
              if ($compare > $compare2) {
                echo '<h1 class="win_message">' . $_SESSION['NAME'] . 'の勝利</h1>';
                $_SESSION['WIN'] = 1;
              } elseif ($compare < $compare2) {
                echo '<h1 class="win_message">' . $_SESSION['NAME_2'] . 'の勝利</h1>';
                $_SESSION['WIN'] = 2;
              } else {
                echo '<h1 class="win_message">同点</h1>';
                $_SESSION['WIN'] = 3;
              }
            }
          }
        }
      }
    }
  } elseif(!empty($_POST['fold']) || !empty($_POST['fold_2']) || $_SESSION['DONE'] == 1) {
    $_SESSION['DONE'] = 1;
    if (!empty($_POST['fold'])) {
      $_SESSION['WIN'] = 2;
    }
    if (!empty($_POST['fold_2'])) {
      $_SESSION['WIN'] = 1;
    }
    if ($_SESSION['WIN'] == 1) {
      echo '<h1 class="win_message">' . $_SESSION['NAME'] . 'の勝利</h1>';
    } else {
      echo '<h1 class="win_message">' . $_SESSION['NAME_2'] . 'の勝利</h1>';
    }
  } else {
    header('Location: ./');
  }
  ?>
  <form action="end.php" method="post" class="end">
    <input type="submit" name="end" value="終了" class="end_message invite">
  </form>
</body>

</html>