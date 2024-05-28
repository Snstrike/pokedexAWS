provider "aws" {
  region = "us-east-1"  
}

resource "aws_key_pair" "pokedex_key" {
  key_name   = "pokedex-key"
  public_key = file("C:\Users\luiso\.ssh\pokedex-key.pub")
}

resource "aws_security_group" "pokedex_sg" {
  name        = "pokedex-sg"
  description = "Allow SSH and HTTP"

  ingress {
    from_port   = 22
    to_port     = 22
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  ingress {
    from_port   = 80
    to_port     = 80
    protocol    = "tcp"
    cidr_blocks = ["0.0.0.0/0"]
  }

  egress {
    from_port   = 0
    to_port     = 0
    protocol    = "-1"
    cidr_blocks = ["0.0.0.0/0"]
  }
}

resource "aws_instance" "pokedex_server" {
  ami           = "ami-0c55b159cbfafe1f0"  # AMI de Ubuntu
  instance_type = "t2.micro"
  key_name      = aws_key_pair.pokedex_key.key_name
  security_groups = [aws_security_group.pokedex_sg.name]

  tags = {
    Name = "PokedexServer"
  }

  user_data = <<-EOF
              #!/bin/bash
              apt-get update
              apt-get install -y apache2 php libapache2-mod-php mysql-client git
              cd /var/www/html
              sudo git clone https://github.com/tuusuario/pokedex.git .
              sudo systemctl restart apache2
              EOF
}

resource "aws_db_instance" "pokedex_db" {
  identifier = "pokedex-db"
  engine = "mysql"
  instance_class = "db.t2.micro"
  allocated_storage = 20
  username = "admin"
  password = "yourpassword"
  db_name = "pokedex"
  skip_final_snapshot = true

  publicly_accessible = true

  vpc_security_group_ids = [aws_security_group.pokedex_sg.id]
}

output "instance_ip" {
  value = aws_instance.pokedex_server.public_ip
}
